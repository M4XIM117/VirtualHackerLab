<?php
    echo "<table style='border: solid 1px black;'>";
    echo "<tr>
                <th>id</th>
                <th>chat_id</th>
                <th>sender_id</th>
                <th>receiver_id</th>
                <th>replying_to_id</th>
                <th>message_deleted_at</th>
                <th>message</th>
                <th>send_at</th>
                <th>call_duration_in_min</th>
                <th>latitude</th>
                <th>longitude</th>
              </tr>";

    class TableRows extends RecursiveIteratorIterator {
        function __construct($it) {
            parent::__construct($it, self::LEAVES_ONLY);
        }

        function current() {
            return "<td style='width:150px;border:1px solid black; text-align: center;'>" . parent::current(). "</td>";
        }

        function beginChildren() {
            echo "<tr>";
        }

        function endChildren() {
            echo "</tr>" . "\n";
        }
    }

    $servername = 'webshell-database-1';
    $username = 'root';
    $password = 'root';
    $port = 3306;

    try {
        $conn = new PDO("mysql:host=$servername;port=$port;dbname=messenger", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo 'Returns the joined table between messages and meta_data_messages';

        $sql = 'SELECT  m.id, m.chat_id, m.sender_id, m.receiver_id, m.reply_to_id, m.deleted_at, m.text, m.created_at, 
                        mdm.call_duration, ST_X(mdm.position), ST_Y(mdm.position)
                FROM    messages as m, meta_data_messages as mdm 
                WHERE   m.id = mdm.id';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
            echo $v;
        }
    } catch(PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
