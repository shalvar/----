<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Chatbot in PHP | CodingNepal</title>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
    <div class="typing-field">
        <form class="input-data" action="/chat.php" method="POST">
            <input id="data" type="text" placeholder="Type something here.." required name="txt" autofocus>
            <button id="send-btn">Send</button>
        </form>
        <?php
        $conn = new mysqli("localhost", "root", "", "messenger") or ("вы не подключены");
        $txt = $_POST["txt"];
        if (isset($txt)) {
            $pattern = "/#(\w+)/";
            preg_match_all($pattern, $txt, $key_word);
            $conn->query("INSERT INTO `message`(`text`) VALUES ('$txt')");
            $id = $conn->insert_id;
            $str = $key_word[1][0];
            $conn->query("INSERT INTO `keyword`(`message_id`,`key_word`) VALUES ('$id','$str')");
            header("Refresh:0");
        }
        $conn->close();
        ?>
    </div>
    <div class="form">
        <?php
        $conn = new mysqli("localhost", "root", "", "messenger") or ("вы не подключены");
        $sql = "SELECT * FROM `message`";
        if ($result = $conn->query($sql)) {
            foreach ($result as $row) {
                $id = $row["id"];
                $text = $row["text"];
                $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>' . $text . '</p></div></div>';
                echo $msg;
            }
        }
        $conn->close();
        ?>
    </div>


</body>

</html>