<?php

namespace App\Service\Biblio;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class Client
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $biblioClient) {
        $this->client = $biblioClient;
    }

    /**
     * @return Book[]
     *
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getBooks(): array {
        try {
            $res = $this->client->request('GET', 'books');
        } catch (TransportExceptionInterface $e) {
            return [];
        }

        if ($res->getStatusCode() !== 200) {
            return [];
        }

        return $this->decodeBooks($res);
    }

    /**
     * @param string $query
     * @return Book[]
     */
    public function searchBooks(string $query): array {
        try {
            $res = $this->client->request('GET', 'books/search', ['query' => [
                'title' => $query,
            ]]);
        } catch (TransportExceptionInterface $e) {
            return [];
        }

        if ($res->getStatusCode() !== 200) {
            return [];
        }

        return $this->decodeBooks($res);
    }

    /**
     * @param string $query
     * @return Author[]
     */
    public function searchAuthors(string $query): array {
        try {
            $res = $this->client->request('GET', 'authors/search', ['query' => [
                'name' => $query,
            ]]);
        } catch (TransportExceptionInterface $e) {
            return [];
        }

        if ($res->getStatusCode() !== 200) {
            return [];
        }

        return $this->decodeAuthors($res);
    }

    private function decodeBooks(ResponseInterface $response): array {
        $result = [];
        foreach ($response->toArray() as $item) {
            $result[] = Book::fromJSON($item);
        }

        return $result;
    }

    private function decodeAuthors(ResponseInterface $response): array {
        $result = [];
        foreach ($response->toArray() as $item) {
            $result[] = Author::fromJSON($item);
        }

        return $result;
    }

}
