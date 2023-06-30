<?php
    echo "<table style='border: solid 1px black;'>";
    echo "<tr>
            <th>id</th>
            <th>phone number</th>
            <th>country code</th>
            <th>system language</th>
            <th>device id</th>
            <th>first name</th>
            <th>last name</th>
            <th>username</th>
            <th>status</th>
            <th>created at</th>
            <th>login time</th>
            <th>logout time</th>
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
    $port = 3307;

    try {
        $conn = new PDO("mysql:host=$servername;port=$port;dbname=messenger", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo 'Returns the joined table between users, user_informations and meta_data_users';

        $sql = 'SELECT  u.id, u.phone_number, u.country_code, u.system_language, u.device_id, 
                        ui.first_name, ui.last_name, ui.username, ui.status, u.created_at,
                        m.login_time, m.logout_time, ST_X(m.position), ST_Y(m.position) 
                FROM    users as u, user_informations as ui, meta_data_users as m 
                WHERE   u.id = ui.user_id AND u.id = m.id';
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
