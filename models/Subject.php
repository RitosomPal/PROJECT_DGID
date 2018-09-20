<?php
    include_once('./config/Database.php');
    
    class Subject {
        // Class Variable
        private $database;

        // Department Subject Info
        private $reg;
        private $branchCode;
        private $code;
        private $sem;
        private $name;
        private $uid;
        private $empid;

        public function __construct($clgReg) {
            $this->database = new Database();
            $this->reg = htmlspecialchars(strip_tags($clgReg));
        }

        # Add Subject
        public function add($post) {
            extract($post);

            // Clean Data
            $this->branchCode = htmlspecialchars(strip_tags($deptCode));
            $this->name = htmlspecialchars(strip_tags($subName));
            $this->code = htmlspecialchars(strip_tags($subCode));
            $this->sem = htmlspecialchars(strip_tags($subSem));

            // All SQL Commands
            $sql0 = 'SELECT * FROM subjects WHERE code = :code';
            $sql1 = 'INSERT INTO subjects SET name = :name, code = :code, sem = :sem';
            $sql2 = 'CREATE TABLE '.$this->reg.'_'.$this->branchCode.' . att_'.$this->code.' ( id INT NOT NULL AUTO_INCREMENT , uid VARCHAR(255) NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB';
            $sql3 = 'CREATE TABLE '.$this->reg.'_'.$this->branchCode.' . lab_'.$this->code.' ( id INT NOT NULL AUTO_INCREMENT , uid VARCHAR(255) NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB';
            $sql4 = 'CREATE TABLE '.$this->reg.'_'.$this->branchCode.' . int_'.$this->code.' ( id INT NOT NULL AUTO_INCREMENT ,  uid VARCHAR(255) NOT NULL ,  1st INT ,  2nd INT ,    PRIMARY KEY  (id, uid)) ENGINE = InnoDB;';
            $sql5 = 'CREATE TABLE '.$this->reg.'_'.$this->branchCode.' . asg_'.$this->code.' ( id INT NOT NULL AUTO_INCREMENT , uid VARCHAR(255) NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB';

            // Checking For Subject's Existence
            $db = $this->reg . '_' . $this->branchCode;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            $stmt->bindParam(':code', $this->code);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            if ($stmt->rowCount() != 0) {
                return "Subject already exist!";
            }

            // Inserting Data into Subjects Table under Department Database
            $stmt = $conn->prepare($sql1);
            $stmt->bindParam(':code', $this->code);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':sem', $this->sem);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }

            // Creating Subject Attendance Table in Department Database
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql2);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }

            // Creating Lab Marks Table in Department Database
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql3);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }

            // Creating Internal Marks Table in Department Database
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql4);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }

            // Creating Internal Marks Table in Department Database
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql5);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }

            return true;
        }

        # Update Subject Info
        public function update($post) {
            extract($post);
            
            // Clean Data
            $this->branchCode = htmlspecialchars(strip_tags($deptCode));
            $this->code = htmlspecialchars(strip_tags($subCode));
            $this->empid = htmlspecialchars(strip_tags($empId));

            // SQL Command
            $sql0 = 'UPDATE subjects SET empid = :empid WHERE code = :code';

            //Update
            $db = $this->reg . '_' . $this->branchCode;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            $stmt->bindParam(':code', $this->code);
            $stmt->bindParam(':empid', $this->empid);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            return true;
        }

        # Subject Names
        public function names($deptCode) {
            // Clean Data
            $this->branchCode = htmlspecialchars(strip_tags($deptCode));

            // SQL Command
            $sql0 = 'SELECT * FROM subjects';

            // Getting Names
            $db = $this->reg . '_' . $this->branchCode;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            if ($stmt->rowCount() == 0) {
                return false;
            }
            return $stmt->fetchAll();
        }

        # Subject Names Sem Wise
        public function names_sem($deptCode, $sem) {
            // Clean Data
            $this->branchCode = htmlspecialchars(strip_tags($deptCode));
            $this->sem = htmlspecialchars(strip_tags($sem));

            // SQL Command
            $sql0 = 'SELECT * FROM subjects WHERE sem = :sem';

            // Getting Names
            $db = $this->reg . '_' . $this->branchCode;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            $stmt->bindParam(':sem', $this->sem);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            if ($stmt->rowCount() == 0) {
                return false;
            }
            return $stmt->fetchAll();
        }

        # Subject Info
        public function info($deptCode, $subCode) {
            // Clean Data
            $this->branchCode = htmlspecialchars(strip_tags($deptCode));
            $this->code = htmlspecialchars(strip_tags($subCode));

            // All SQL Commands
            $sql0 = 'SELECT * FROM subjects WHERE code = :code';

            // Get Info
            $db = $this->reg . '_' . $this->branchCode;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            $stmt->bindParam(':code', $this->code);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            if ($stmt->rowCount() == 0) {
                return false;
            }
            return $stmt->fetchAll();
        }

        # Add UID To Subject Table
        public function addUID ($stdUid, $sem, $deptCode) {
            // Clean Data
            $this->branchCode = htmlspecialchars(strip_tags($deptCode));
            $this->uid = htmlspecialchars(strip_tags($stdUid));

            $subs = $this->names_sem($deptCode,$sem);

            $db = $this->reg . '_' . $this->branchCode;
            $conn = $this->database->connectSpec($db);

            foreach ($subs as $sc) {
                $sql0 = 'INSERT INTO att_'.$sc['code'].' SET uid=:uid';
                $sql1 = 'INSERT INTO lab_'.$sc['code'].' SET uid=:uid';
                $sql2 = 'INSERT INTO int_'.$sc['code'].' SET uid=:uid';
                $sql3 = 'INSERT INTO asg_'.$sc['code'].' SET uid=:uid';
                
                // Inserting UID to different subject table
                $stmt0 = $conn->prepare($sql0);
                $stmt1 = $conn->prepare($sql1);
                $stmt2 = $conn->prepare($sql2);
                $stmt3 = $conn->prepare($sql3);
                $stmt0->bindParam(':uid', $this->uid);
                $stmt1->bindParam(':uid', $this->uid);
                $stmt2->bindParam(':uid', $this->uid);
                $stmt3->bindParam(':uid', $this->uid);
                if ($stmt0->execute() && $stmt1->execute() && $stmt2->execute() && $stmt3->execute()) {} else {
                    return 'Error.';
                }

            }
            return true;
        }

        # Delete Subject

    }