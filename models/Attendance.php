<?php
    include_once('./config/Database.php');

    class Attendance {
        // Class Variable
        private $database;

        // Attendance Info
        private $reg;
        private $branchCode;
        private $subject_code;
        private $std_att_list;
        private $submit_date;

        public function __construct($clgReg) {
            $this->database = new Database();
            $this->reg = htmlspecialchars(strip_tags($clgReg));
        }

        # Submit Attendance
        public function submit($deptCode, $subject_code, $std_att_list, $sub_date) {
            // Clear Data
            $this->branchCode = htmlspecialchars(strip_tags($deptCode));
            $this->subject_code = htmlspecialchars(strip_tags($subject_code));
            $this->std_att_list = htmlspecialchars(strip_tags($std_att_list));
            $sub_date = htmlspecialchars(strip_tags($sub_date));

            if (empty($sub_date)) {
                // current date
                $this->submit_date = date("d_m_y");
            } else {
                $this->submit_date = $sub_date;
            }

            // sql Commands
            $sql0 = 'SHOW COLUMNS FROM att_'.$this->subject_code;
            $sql1 = 'ALTER TABLE att_'.$this->subject_code. ' ADD '.$this->submit_date.' INT NOT NULL AFTER '.$lstColumn;
            $sql2 = 'SELECT uid FROM att_'.$this->subject_code;
            $sql3 = 'UPDATE att_'.$this->subject_code.' SET '.$this->submit_date.' = :attendance WHERE uid = :uid';

            // get Last Column
            $db = $this->reg . '_' . $this->branchCode;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            $row = $stmt->fetchAll(PDO::FETCH_BOTH);
            $num = count($row);
            $lstColumn = $row[$num-1]['Field'];
            $e = 1;

            // Check if submit date exist or not
            foreach ($row as $r) {
                if ($r['Field'] == $dt) {
                    $e=0;
                    break;
                }
            }

            // Create Table if not Exist
            if ($e) {
                $stmt = $conn->prepare($sql1);
                if ($stmt->execute()) {} else {
                    return $stmt->error;
                }
            }

            // Get Student uid
            $stmt = $conn->prepare($sql2);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            $arrId = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // set Attendance
            $c = 0;
            foreach ($arrId as $id) {
                $stmt = $conn->prepare($sql2);
                $stmt->bindParam(':attendance', $std_att_list[$c]);
                $stmt->bindParam(':uid', $id['uid']);
                if ($stmt->execute()) {} else {
                    return $stmt->error;
                }
                $c++;
            }
            
        }

        # Total Attendance
        public function total($clgReg, $deptCode, $subject_code) {
            // Clear Data
            $this->reg = htmlspecialchars(strip_tags($clgReg));
            $this->branchCode = htmlspecialchars(strip_tags($deptCode));
            $this->subject_code = htmlspecialchars(strip_tags($subject_code));

            // sql commands
            $sql0 = 'SHOW COLUMNS FROM att_'.$this->subject_code;
            $sql1 = 'SELECT uid,  ( :cols ) As "Total" FROM att_'.$this->subject_code;

            // get all Column Names
            $db = $this->reg . '_' . $this->branchCode;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            $row = $stmt->fetchAll(PDO::FETCH_BOTH);
            $col="";

            foreach ($row as $r) {
                $col = $col.' ,'.$r['Field'].' ';
            }   

            $col = substr($col,13);
            $colA = preg_replace('/[ ,]+/', '+', trim($col));

            $stmt = $conn->prepare($sql1);
            $stmt->bindParam(':cols', $colA);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $row;
            
        }

    }