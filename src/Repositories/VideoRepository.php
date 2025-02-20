<?php

namespace alura\mvc\Repositories;

use alura\mvc\Models\Video;
use PDO;

class VideoRepository
{
    public function __construct(private PDO $connection)
    {
        $this->connection = $connection;
    }
        /**
         * Summary of getAll
         * @return Video[]
         */
        public function getAll(): array
    {
        $sqlQuery = "SELECT * FROM videos";
        $statement = $this->connection->query($sqlQuery);
        $videos = $statement->fetchAll();

        return array_map(
            $this->hydratateVideo(...),
            $videos);
    }

    public function getById(int $id): Video
    {
        $sql = "SELECT * FROM videos WHERE id = :id;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue("id", $id, PDO::PARAM_INT);
        $statement->execute();
        $video = $statement->fetch();

        return $this->hydratateVideo($video);
    }

    public function add(Video $video): bool
    {
        $sql = "INSERT INTO videos (url, title, image_path) VALUES (:url, :title, :image_path);";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue("url",$video->url, PDO::PARAM_STR);
        $statement->bindValue("title",$video->title, PDO::PARAM_STR);
        $statement->bindValue("image_path",$video->filePath(), PDO::PARAM_STR);
        
        $result = $statement->execute();

        $id = $this->connection->lastInsertId();
        $video->setId( intval($id));

        return $result;
    }

    public function update(Video $video): bool
    {
        $sql = "UPDATE videos SET url = :url, title = :title image_path = :image_path WHERE id = :id;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue("url",$video->url, PDO::PARAM_STR);
        $statement->bindValue("title",$video->title, PDO::PARAM_STR);
        $statement->bindValue("image_path",$video->filePath(), PDO::PARAM_STR);
        $statement->bindValue("id",$video->id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function remove(int $id): bool
    {
        $sql = "DELETE FROM videos WHERE id = :id;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue("id", $id, PDO::PARAM_INT);
        
        return $statement->execute();
    }

    private function hydratateVideo(array $dataVideo): Video
    {
        $video = new Video (
            $dataVideo["url"],
            $dataVideo["title"],
        );
        $video->setId($dataVideo["id"]);
        return $video;
    }
}