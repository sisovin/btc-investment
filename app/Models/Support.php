<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Support extends Model
{
    protected $table = 'support_tickets';
    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'status',
        'priority',
        'category',
        'assigned_to'
    ];

    /**
     * Ticket statuses
     */
    const STATUSES = [
        'open',
        'in_progress',
        'waiting_for_user',
        'resolved',
        'closed'
    ];

    /**
     * Ticket priorities
     */
    const PRIORITIES = [
        'low',
        'medium',
        'high',
        'urgent'
    ];

    /**
     * Ticket categories
     */
    const CATEGORIES = [
        'general',
        'deposit',
        'withdrawal',
        'investment',
        'technical',
        'account',
        'referral'
    ];

    /**
     * Get tickets by user
     */
    public static function getByUser($userId)
    {
        $stmt = self::$db->prepare("
            SELECT st.*, u.name as user_name,
                   (SELECT COUNT(*) FROM support_replies sr WHERE sr.ticket_id = st.id) as replies_count,
                   (SELECT sr.created_at FROM support_replies sr WHERE sr.ticket_id = st.id ORDER BY sr.created_at DESC LIMIT 1) as last_reply
            FROM support_tickets st
            JOIN users u ON st.user_id = u.id
            WHERE st.user_id = ?
            ORDER BY st.updated_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all tickets for admin
     */
    public static function getAllForAdmin($status = null, $priority = null)
    {
        $query = "
            SELECT st.*, u.name as user_name, u.email as user_email,
                   (SELECT COUNT(*) FROM support_replies sr WHERE sr.ticket_id = st.id) as replies_count,
                   (SELECT sr.created_at FROM support_replies sr WHERE sr.ticket_id = st.id ORDER BY sr.created_at DESC LIMIT 1) as last_reply
            FROM support_tickets st
            JOIN users u ON st.user_id = u.id
        ";
        $params = [];

        if ($status) {
            $query .= " WHERE st.status = ?";
            $params[] = $status;
        }

        if ($priority) {
            $whereClause = $status ? " AND" : " WHERE";
            $query .= "$whereClause st.priority = ?";
            $params[] = $priority;
        }

        $query .= " ORDER BY st.priority DESC, st.created_at DESC";

        $stmt = self::$db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get ticket with replies
     */
    public static function getWithReplies($ticketId)
    {
        // Get ticket
        $stmt = self::$db->prepare("
            SELECT st.*, u.name as user_name, u.email as user_email
            FROM support_tickets st
            JOIN users u ON st.user_id = u.id
            WHERE st.id = ?
        ");
        $stmt->execute([$ticketId]);
        $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ticket) return null;

        // Get replies
        $stmt = self::$db->prepare("
            SELECT sr.*, u.name as reply_user_name, u.email as reply_user_email
            FROM support_replies sr
            LEFT JOIN users u ON sr.user_id = u.id
            WHERE sr.ticket_id = ?
            ORDER BY sr.created_at ASC
        ");
        $stmt->execute([$ticketId]);
        $replies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $ticket['replies'] = $replies;
        return $ticket;
    }

    /**
     * Create new ticket
     */
    public static function createTicket($userId, $subject, $message, $category = 'general', $priority = 'medium')
    {
        return self::create([
            'user_id' => $userId,
            'subject' => $subject,
            'message' => $message,
            'status' => 'open',
            'priority' => $priority,
            'category' => $category
        ]);
    }

    /**
     * Add reply to ticket
     */
    public static function addReply($ticketId, $userId, $message, $isAdmin = false)
    {
        $stmt = self::$db->prepare("
            INSERT INTO support_replies (ticket_id, user_id, message, is_admin, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$ticketId, $userId, $message, $isAdmin ? 1 : 0]);

        // Update ticket updated_at
        $stmt = self::$db->prepare("UPDATE support_tickets SET updated_at = NOW() WHERE id = ?");
        $stmt->execute([$ticketId]);

        // If admin reply, change status to waiting_for_user
        if ($isAdmin) {
            $stmt = self::$db->prepare("UPDATE support_tickets SET status = 'waiting_for_user' WHERE id = ?");
            $stmt->execute([$ticketId]);
        } else {
            // If user reply, change status to open
            $stmt = self::$db->prepare("UPDATE support_tickets SET status = 'open' WHERE id = ?");
            $stmt->execute([$ticketId]);
        }

        return self::$db->lastInsertId();
    }

    /**
     * Update ticket status
     */
    public function updateStatus($status)
    {
        if (!in_array($status, self::STATUSES)) return false;

        $stmt = self::$db->prepare("UPDATE support_tickets SET status = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$status, $this->id]);
    }

    /**
     * Assign ticket to admin
     */
    public function assignTo($adminId)
    {
        $stmt = self::$db->prepare("UPDATE support_tickets SET assigned_to = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$adminId, $this->id]);
    }

    /**
     * Get ticket statistics
     */
    public static function getStats()
    {
        $stmt = self::$db->query("
            SELECT
                COUNT(*) as total_tickets,
                COUNT(CASE WHEN status = 'open' THEN 1 END) as open_tickets,
                COUNT(CASE WHEN status = 'in_progress' THEN 1 END) as in_progress_tickets,
                COUNT(CASE WHEN status = 'resolved' THEN 1 END) as resolved_tickets,
                COUNT(CASE WHEN priority = 'urgent' THEN 1 END) as urgent_tickets,
                AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_resolution_time
            FROM support_tickets
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get tickets by category
     */
    public static function getByCategory($category)
    {
        $stmt = self::$db->prepare("
            SELECT st.*, u.name as user_name,
                   (SELECT COUNT(*) FROM support_replies sr WHERE sr.ticket_id = st.id) as replies_count
            FROM support_tickets st
            JOIN users u ON st.user_id = u.id
            WHERE st.category = ?
            ORDER BY st.created_at DESC
        ");
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Close ticket
     */
    public function close()
    {
        return $this->updateStatus('closed');
    }

    /**
     * Reopen ticket
     */
    public function reopen()
    {
        return $this->updateStatus('open');
    }

    /**
     * Get unread tickets count for admin
     */
    public static function getUnreadCount()
    {
        $stmt = self::$db->query("
            SELECT COUNT(*) as count
            FROM support_tickets
            WHERE status IN ('open', 'waiting_for_user')
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    /**
     * Get tickets assigned to admin
     */
    public static function getAssignedTo($adminId)
    {
        $stmt = self::$db->prepare("
            SELECT st.*, u.name as user_name,
                   (SELECT COUNT(*) FROM support_replies sr WHERE sr.ticket_id = st.id) as replies_count
            FROM support_tickets st
            JOIN users u ON st.user_id = u.id
            WHERE st.assigned_to = ?
            ORDER BY st.priority DESC, st.updated_at DESC
        ");
        $stmt->execute([$adminId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Validate ticket data
     */
    public static function validate($data)
    {
        $errors = [];

        if (empty($data['subject'])) {
            $errors[] = 'Subject is required';
        }

        if (empty($data['message'])) {
            $errors[] = 'Message is required';
        }

        if (!empty($data['priority']) && !in_array($data['priority'], self::PRIORITIES)) {
            $errors[] = 'Invalid priority';
        }

        if (!empty($data['category']) && !in_array($data['category'], self::CATEGORIES)) {
            $errors[] = 'Invalid category';
        }

        return $errors;
    }

    /**
     * Get priority color for UI
     */
    public function getPriorityColor()
    {
        $colors = [
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'urgent' => 'red'
        ];

        return $colors[$this->priority] ?? 'gray';
    }

    /**
     * Get status color for UI
     */
    public function getStatusColor()
    {
        $colors = [
            'open' => 'green',
            'in_progress' => 'blue',
            'waiting_for_user' => 'yellow',
            'resolved' => 'gray',
            'closed' => 'red'
        ];

        return $colors[$this->status] ?? 'gray';
    }
}