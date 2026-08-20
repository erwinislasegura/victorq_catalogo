<?php
/**
 * Modelo de Solicitudes de Cotización
 */

class Quote extends Model {
    protected string $table = 'quotes';

    public function getAllWithProduct(): array {
        if (!$this->db) return [];
        $sql = "SELECT q.*, p.name as product_name, p.model as product_model 
                FROM quotes q 
                LEFT JOIN products p ON q.product_id = p.id 
                ORDER BY q.created_at DESC";
        return $this->rawQuery($sql);
    }

    public function getLatest(int $limit = 5): array {
        if (!$this->db) return [];
        $sql = "SELECT q.*, p.name as product_name, p.model as product_model 
                FROM quotes q 
                LEFT JOIN products p ON q.product_id = p.id 
                ORDER BY q.created_at DESC LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCountsByStatus(): array {
        if (!$this->db) return ['pending' => 0, 'in_review' => 0, 'quoted' => 0, 'closed' => 0, 'total' => 0];
        $sql = "SELECT status, COUNT(*) as count FROM quotes GROUP BY status";
        $rows = $this->rawQuery($sql);
        
        $res = ['pending' => 0, 'in_review' => 0, 'quoted' => 0, 'closed' => 0, 'total' => 0];
        foreach ($rows as $r) {
            $res[$r['status']] = (int)$r['count'];
            $res['total'] += (int)$r['count'];
        }
        return $res;
    }
}
