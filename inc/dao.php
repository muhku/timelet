<?php

/*
 * Copyright (c) 2007, Matias Muhonen <mmu@iki.fi>
 * 
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * Redistributions of source code must retain the above copyright notice, this
 * list of conditions and the following disclaimer.
 *
 * Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation and/or
 * other materials provided with the distribution.
 *
 * Neither the name of the <ORGANIZATION> nor the names of its contributors may be
 * used to endorse or promote products derived from this software without specific
 * prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

class DAO {
	var $db_dsn;

	function set_db_dsn($dsn) {
		$this->db_dsn = $dsn;
	}

	function get_connection() {
		$settings = new Settings();
		$dsn = $settings-> get_db_dsn();
		$conn =& DB::connect($dsn);
		if (DB::isError($conn)) {
			die("Cannot connect: " . $conn->getMessage());
		}
		return $conn;
	}

	function save_worklog_entry($project, $user, $work_type, $year, $week, $work_description, $time_worked) {
		$conn = $this->get_connection();
		$user_id = $user->get_id();
		$project_id = $project->get_id();
		$work_type_id = $work_type->get_id();
		$sql = "INSERT INTO worklog(user_id,project_id,work_type_id,year,week,work_description,time_worked) VALUES($user_id,$project_id,$work_type_id,$year,$week,'$work_description','$time_worked')";
		$conn->query($sql);
	}

	function get_work_distribution($user_id) {
		$work_distribution = array();
		$conn = $this->get_connection();
		$sql = "select wt.name,sum(w.time_worked) as tot from worklog w inner join work_type wt on wt.id=w.work_type_id where w.user_id=$user_id group by w.work_type_id";
		$res =& $conn->query($sql);
		while ($row =& $res->fetchRow(DB_FETCHMODE_ORDERED)) {
			$work_distribution[] = array("work_type" => $row[0], "total" => $row[1]
			);
		}
		return $work_distribution;
	}

	function get_work_types() {
		$work_types = array();
		$conn = $this->get_connection();
		$res =& $conn->query("SELECT * FROM work_type ORDER BY id");
		while ($row =& $res->fetchRow(DB_FETCHMODE_ORDERED)) {
			$work_type = new WorkType();
			$work_type->set_id($row[0]);
			$work_type->set_name($row[1]);
			$work_types[] = $work_type;
		}
		return $work_types;
	}

        function get_weeks() {
                $weeks = array();
                $conn = $this->get_connection();
                $res =& $conn->query("SELECT DISTINCT week,year FROM worklog ORDER BY year,week");
                while ($row =& $res->fetchRow(DB_FETCHMODE_ORDERED)) {
                        $week = new Week();
                        $week->set_week($row[0]);
                        $week->set_year($row[1]);
                        $weeks[] = $week;
                }
                return $weeks;
        }

	function get_work_type($id) {
		foreach ($this->get_work_types() as $w) {
			if ($w->get_id() == $id) {
				return $w;
			} 
		}
		return NULL;
	}

	function get_worklog_entries($project, $user, $year, $week) {
		$worklog_entries = array();
		$user_id = $user->get_id();
		$project_id = $project->get_id();
		$conn = $this->get_connection();
		$res =& $conn->query("SELECT w.*,p.*,u.*,wt.* FROM worklog w INNER JOIN project p ON p.id=w.project_id INNER JOIN user u ON u.id=w.user_id INNER JOIN work_type wt ON wt.id=w.work_type_id WHERE w.project_id=$project_id AND w.user_id=$user_id AND w.year=$year AND w.week=$week");
		while ($row =& $res->fetchRow(DB_FETCHMODE_ORDERED)) {
			$project = new Project();
			$project->set_id($row[8]);
			$project->set_name($row[9]);
			$user = new User();
			$user->set_id($row[10]);
			$user->set_username($row[11]);
			$user->set_firstname($row[12]);
			$user->set_lastname($row[13]);
			$work_type = new WorkType();
			$work_type->set_id($row[14]);
			$work_type->set_name($row[15]);
			$worklog_entry = new WorkLogEntry();
			$worklog_entry->set_id($row[0]);
			$worklog_entry->set_user($user);
			$worklog_entry->set_project($project);
			$worklog_entry->set_work_type($work_type);
			$worklog_entry->set_year($row[4]);
			$worklog_entry->set_week($row[5]);
			$worklog_entry->set_work_description($row[6]);
			$worklog_entry->set_time_worked($row[7]); 
			$worklog_entries[] = $worklog_entry;
		}
		return $worklog_entries;
	}

	function get_user($username) {
		$user = NULL;
		$conn = $this->get_connection();
		$res =& $conn->query("SELECT * FROM user WHERE username='$username'");
		if ($row =& $res->fetchRow(DB_FETCHMODE_ASSOC)) {
			$user = new User();
			$user->set_id($row["id"]);
			$user->set_username($row["username"]);
			$user->set_firstname($row["firstname"]);
			$user->set_lastname($row["lastname"]);
		}
		return $user;
	}

	function get_users() {
		$users = array();
		$conn = $this->get_connection();
		$res =& $conn->query("SELECT * FROM user ORDER BY id");
		while ($row =& $res->fetchRow(DB_FETCHMODE_ASSOC)) {
			$user = new User();
			$user->set_id($row["id"]);
			$user->set_username($row["username"]);
			$user->set_firstname($row["firstname"]);
			$user->set_lastname($row["lastname"]);
			$users[] = $user;
		}
		return $users;
	}

	function get_personal_report() {
		$sql = "SELECT week,year,user_id,SUM(time_worked) AS tot FROM worklog WHERE project_id=1 GROUP BY week,year,user_id ORDER BY year,week";
		$report_data = array();
		$conn = $this->get_connection();
		$res =& $conn->query($sql);
		while ($row =& $res->fetchRow(DB_FETCHMODE_ASSOC)) {
			$year = intval($row["year"]);
			$week = intval($row["week"]);
			$user = intval($row["user_id"]);
			$report_data[$year][$week][$user] = array($user, $row["tot"]);
		}

		$users = $this->get_users();
		// Calculate data size
		$week_count = 0;
		$user_count = count($users);

		foreach ($report_data as $year) {
			foreach ($year as $week) {
				$week_count++;
			}
		}

		// Assign data to the matrix
		$t = new TimeTrackingTable();
		$t->set_size($week_count + 2, $user_count + 2);

		// First row
		$usermap = array();
		$t->set_data(0, 0, "Week");
		$i = 1;
		foreach ($users as $user) {
			$t->set_data(0, $i, $user->get_firstname());
			$usermap[$user->get_id()] = $i;
			$i++;
		}
		$t->set_data(0, $i, "Total");

		// Weekly data
		$cur_row = 1;
		foreach ($report_data as $year) {
			foreach ($year as $week_name => $week) {
				$t->set_data($cur_row, 0, $week_name);
				$week_total = 0;
				foreach ($week as $user_data) {
					$col = $usermap[$user_data[0]];
					$t->set_data($cur_row, $col, $user_data[1]);
					$week_total += $user_data[1];
				}
				$t->set_data($cur_row, count($users) + 1, $week_total);
				$cur_row++;
			}
		}

		// Calculate total sums for each user
		foreach ($usermap as $user_col) {
			$total_sum = 0;
			$cur_row = 0;
			for ($row=0; $row < $week_count; $row++) {
				$cur_row = $row + 1;
				$data = $t->get_data($cur_row, $user_col);
				$total_sum += $data;
			}
			$t->set_data($cur_row + 1, 0, "Yht");
			$t->set_data($cur_row + 1, $user_col, $total_sum);
		}

		// Last col, total for all users
		$total_sum = 0;
		$cur_row = 0;
		for ($row=0; $row < $week_count; $row++) {
			$cur_row = $row + 1;
			$total_sum += $t->get_data($cur_row, $user_count + 1);
		}
		$t->set_data($cur_row + 1, $user_count + 1, $total_sum);
		return $t;
	}

	function get_project_report() {
		$weeks = $this->get_weeks();
		$work_types = $this->get_work_types();

		$t = new TimeTrackingTable();
		$t->set_size(count($weeks) + 2, count($work_types) + 2);

		// The first row: work types 
		$work_type_map = array();
		$t->set_data(0, 0, "");
		$col = 1;
		foreach ($work_types as $type) {
			$work_type_map[$type->get_id()] = $col;
			$t->set_data(0, $col++, $type->get_id()); 
		}
		$t->set_data(0, $col, "Yht");

		// The first column: weeks
		$week_map = array();
		$row = 1;
		foreach ($weeks as $week) {
			$week_map[$week->get_week()] = $row;
			$t->set_data($row++, 0, $week->get_week());
		}
		$t->set_data($row, 0, "Yht");

		$sql = "SELECT year,week,work_type_id,SUM(time_worked) AS tot FROM worklog WHERE project_id=1 GROUP BY year,week,work_type_id";
		$report_data = array();
		$conn = $this->get_connection();
		$res =& $conn->query($sql);
		while ($row =& $res->fetchRow(DB_FETCHMODE_ASSOC)) {
			$week_id = intval($row["week"]);
                        $work_type_id = intval($row["work_type_id"]);
                        $total = $row["tot"];
			$t->set_data($week_map[$week_id], $work_type_map[$work_type_id], $total);
                }

		// Calculate total sums

		// Column sums
		$row = 0;
		for (; $row < count($weeks); $row++) {
			$col = 0;
			$total = 0;
			for (; $col < count($work_types); $col++) {
				$total += $t->get_data($row + 1, $col + 1);
			}
			$t->set_data($row + 1, $col + 1, $total);
		} 

		// Row sums
		$col = 0;
		for (; $col < count($work_types) + 1; $col++) {
			$row = 0;
			$total = 0;
			for (; $row < count($weeks); $row++) {
				$total += $t->get_data($row + 1, $col + 1);
			}
			$t->set_data($row + 1, $col + 1, $total);
		}
		return $t;
	}
}

?>
