<?php

function deleteTask($taskId, PDO $pdo) {
    try {
        $sql = 'DELETE FROM tasks WHERE id = :taskId';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':taskId', $taskId, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'success' => true,
            'message' => 'Task successfully deleted'
        ];
    } catch (PDOException $e) {
        error_log('Delete Task Error: ' . $e->getMessage());
        return [
            'success' => false,
            'message' => 'Failed to delete task'
        ];
    }
}
