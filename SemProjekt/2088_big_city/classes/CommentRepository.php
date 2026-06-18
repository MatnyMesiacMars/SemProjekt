<?php

class CommentRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getAll(): array
    {
        $statement = $this->connection->query(
            'SELECT comments.id,
                    comments.user_id,
                    comments.question,
                    comments.answer,
                    comments.created_at,
                    comments.updated_at,
                    users.username
             FROM comments
             INNER JOIN users ON users.id = comments.user_id
             ORDER BY comments.created_at DESC'
        );

        return $statement->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $statement = $this->connection->prepare(
            'SELECT id, user_id, question, answer, created_at, updated_at
             FROM comments
             WHERE id = :id'
        );

        $statement->execute([
            'id' => $id,
        ]);

        $comment = $statement->fetch();

        return $comment ?: null;
    }

    public function create(int $userId, string $question, ?string $answer): void
    {
        $statement = $this->connection->prepare(
            'INSERT INTO comments (user_id, question, answer)
             VALUES (:user_id, :question, :answer)'
        );

        $statement->execute([
            'user_id' => $userId,
            'question' => $question,
            'answer' => $answer ?? '',
        ]);
    }

    public function update(int $id, string $question, ?string $answer): void
    {
        $statement = $this->connection->prepare(
            'UPDATE comments
             SET question = :question,
                 answer = :answer,
                 updated_at = NOW()
             WHERE id = :id'
        );

        $statement->execute([
            'id' => $id,
            'question' => $question,
            'answer' => $answer ?? '',
        ]);
    }

    public function delete(int $id): void
    {
        $statement = $this->connection->prepare(
            'DELETE FROM comments WHERE id = :id'
        );

        $statement->execute([
            'id' => $id,
        ]);
    }
}
