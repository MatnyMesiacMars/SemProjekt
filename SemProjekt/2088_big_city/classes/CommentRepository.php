<?php

class CommentRepository
{
    public function __construct(private PDO $connection)
    {
    }

    public function getAll(): array
    {
        $statement = $this->connection->query('SELECT id, author, question, answer, created_at FROM comments ORDER BY created_at DESC');

        return $statement->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $statement = $this->connection->prepare('SELECT id, author, question, answer, created_at FROM comments WHERE id = :id');
        $statement->execute(['id' => $id]);
        $comment = $statement->fetch();

        return $comment ?: null;
    }

    public function create(string $author, string $question, string $answer): void
    {
        $statement = $this->connection->prepare('INSERT INTO comments(author, question, answer) VALUES (:author, :question, :answer)');
        $statement->execute([
            'author' => $author,
            'question' => $question,
            'answer' => $answer,
        ]);
    }

    public function update(int $id, string $author, string $question, string $answer): void
    {
        $statement = $this->connection->prepare('UPDATE comments SET author = :author, question = :question, answer = :answer WHERE id = :id');
        $statement->execute([
            'id' => $id,
            'author' => $author,
            'question' => $question,
            'answer' => $answer,
        ]);
    }

    public function delete(int $id): void
    {
        $statement = $this->connection->prepare('DELETE FROM comments WHERE id = :id');
        $statement->execute(['id' => $id]);
    }
}
