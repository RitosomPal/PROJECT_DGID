<?php
    include_once('./config/Database.php');

    class College {
        // Class Variable
        private $database;

        // College Registration Info
        private $name;
        private $reg;
        private $address;
        private $contact;
        private $email;
        private $website;
        private $yoe;
        private $password;

        public function __construct() {
            $this->database = new Database();
        }

        # Registration of an College
        public function register($post) {
            extract($post);

            // Clean Data
            $this->name = htmlspecialchars(strip_tags($clgName));
            $this->reg = htmlspecialchars(strip_tags($clgReg));
            $this->address = htmlspecialchars(strip_tags($clgAddress));
            $this->contact = htmlspecialchars(strip_tags($clgContact));
            $this->email = htmlspecialchars(strip_tags($clgEmail));
            $this->website = htmlspecialchars(strip_tags($clgWeb));
            $this->yoe = htmlspecialchars(strip_tags($clgYoe));
            $this->password = htmlspecialchars(strip_tags($clgPass));

            // All sql commands
            $sql0 = 'SELECT * FROM clg_reg WHERE reg = :reg';
            $sql1 = 'INSERT INTO clg_reg SET reg = :reg';
            $sql2 = 'CREATE DATABASE '.$this->reg.'_details';
            $sql3 = 'CREATE TABLE '.$this->reg.'_details . access_cred ( id INT NOT NULL AUTO_INCREMENT ,  username VARCHAR(255) NOT NULL ,  password LONGTEXT NOT NULL ,  type TEXT NOT NULL ,    PRIMARY KEY  (id, username)) ENGINE = InnoDB';
            $sql4 = 'INSERT INTO access_cred SET username = :reg, password = :password, type = "admin"';
            $sql5 = 'CREATE TABLE '.$this->reg.'_details . info ( id INT NOT NULL AUTO_INCREMENT ,  name TEXT NOT NULL ,  reg VARCHAR(255) NOT NULL ,  address TEXT NOT NULL ,  contact BIGINT NOT NULL ,  email VARCHAR(255) NOT NULL ,  yoe VARCHAR(255) NOT NULL ,  website VARCHAR(255) NOT NULL ,    PRIMARY KEY  (id, reg)) ENGINE = InnoDB';
            $sql6 = 'INSERT INTO info SET name = :name, reg = :reg, address = :address, contact = :contact, email = :email, website = :website, yoe = :yoe';
            $sql7 = 'CREATE TABLE '.$this->reg.'_details . dept ( id INT NOT NULL AUTO_INCREMENT ,  code VARCHAR(255) NOT NULL ,  name TEXT NOT NULL ,  contact BIGINT NOT NULL ,  email VARCHAR(255) NOT NULL, hod VARCHAR(255) ,    PRIMARY KEY  (id, code)) ENGINE = InnoDB';

            try {
                // Checking For Users Existence
                $conn = $this->database->connect();
                $stmt = $conn->prepare($sql0);
                $stmt->bindParam(':reg', $this->reg);
                if ($stmt->execute()) {} else {
                    return $stmt->error;
                }
                if ($stmt->rowCount() != 0) {
                    return "Registration already exist!";
                }

                // Saving Reg No to Our DB
                $stmt = $conn->prepare($sql1);
                $stmt->bindParam(':reg', $this->reg);
                if ($stmt->execute()) {} else {
                    return $stmt->error;
                }

                // Creating College database
                $stmt = $conn->prepare($sql2);
                if ($stmt->execute()) {} else {
                    return $stmt->error;
                }

                // Creating Access_Cred Table in College database
                $db = $this->reg.'_details';
                $conn = $this->database->connectSpec($db);
                $stmt = $conn->prepare($sql3);
                if ($stmt->execute()) {} else {
                    return $stmt->error;
                }

                // Saving Password
                $stmt = $conn->prepare($sql4);
                $stmt->bindParam(':reg', $this->reg);
                $stmt->bindParam(':password', $this->password);
                if ($stmt->execute()) {} else {
                    return $stmt->error;
                }

                

                // Creating Info Table in College database
                $stmt = $conn->prepare($sql5);
                if ($stmt->execute()) {} else {
                    return $stmt->error;
                }

                // Inserting Data into Info Table
                $stmt = $conn->prepare($sql6);
                $stmt->bindParam(':name', $this->name);
                $stmt->bindParam(':reg', $this->reg);
                $stmt->bindParam(':address', $this->address);
                $stmt->bindParam(':contact', $this->contact);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':website', $this->website);
                $stmt->bindParam(':yoe', $this->yoe);
                if ($stmt->execute()) {} else {
                    return $stmt->error;
                }

                // Creating Dept Table in College database
                $stmt = $conn->prepare($sql7);
                if ($stmt->execute()) {} else {
                    return $stmt->error;
                }

                return true;
            }
            catch(PDOException $e) {
                return $e->getMessage();
            }
        }

        # Logging in a College
        public function login($post) {
            extract($post);

            // Clean Data
            $this->reg = htmlspecialchars(strip_tags($clgReg));
            $this->password = htmlspecialchars(strip_tags($clgPass));

            // SQL command
            $sql0 = 'SELECT * FROM access_cred WHERE username = :reg AND password = :password';

            // Checking For Users Access
            $db = $this->reg.'_details';
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            $stmt->bindParam(':reg', $this->reg);
            $stmt->bindParam(':password', $this->password);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            if ($stmt->rowCount() == 1) {
                return true;
            }

            return false;
        }

        # College Info Output
        public function info($reg) {
            $this->reg = htmlspecialchars(strip_tags($reg));

            // SQL command
            $sql0 = 'SELECT * FROM info';

            // Getting Info
            $db = $this->reg.'_details';
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            return $stmt->fetchAll();
        }

        # update College Info
        public function update($post) {
            extract($post);

            // Clean Data
            $this->reg = htmlspecialchars(strip_tags($clgReg));
            $this->contact = htmlspecialchars(strip_tags($clgContact));
            $this->email = htmlspecialchars(strip_tags($clgEmail));
            $this->website = htmlspecialchars(strip_tags($clgWeb));
            $this->password = htmlspecialchars(strip_tags($clgPass));

            // SQL commands
            $sql0 = 'UPDATE info SET contact = :contact, email = :email, website = :website WHERE reg = :reg';
            $sql1 = 'UPDATE access_cred SET password = :password WHERE username = :reg';

            // Updating Info
            $db = $this->reg.'_details';
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            $stmt->bindParam(':contact', $this->contact);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':website', $this->website);
            $stmt->bindParam(':reg', $this->reg);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }

            // Updating Password
            if ($this->password != '') {
                $stmt = $conn->prepare($sql1);
                $stmt->bindParam(':reg', $this->reg);
                $stmt->bindParam(':password', $this->password);
                if ($stmt->execute()) {} else {
                    return $stmt->error;
                }
            }

            return true;
        }

    }