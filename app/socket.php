<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Socket implements MessageComponentInterface {

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $client) {

        // Store the new connection in $this->clients
        $this->clients->attach($client);

        echo "Welcome client {$client->resourceId}!\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {

        foreach ( $this->clients as $client ) {

            if ( $from->resourceId == $client->resourceId ) {
                // $client->send( "Me: $msg" );
                continue;
            } else {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $client) {
    }

    public function onError(ConnectionInterface $client, \Exception $e) {
    }
}