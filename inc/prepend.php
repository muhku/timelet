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

require_once "DB.php";
require_once "dao.php";
require_once "pojo.php";
require_once "calendar_util.php";

class Settings {
	function get_db_dsn() {
		return "mysql://timelet:timelet@localhost/timelet";
	}
} 

class Session {
	var $dao;
	var $auth_user;

	function get_project() {
		// TODO. always 1, no multi-project support :)
		$project = new Project();
		$project->set_id(1);
		return $project;
	}

	function set_auth_user($auth_user) {
		$this->auth_user = $auth_user;
	}

	function set_dao($dao) {
		$this->dao = $dao;
	}

	function get_user() {
		$user = $this->dao->get_user($this->auth_user);
		return $user;
	}
}

class DAOProvider {
	function get_dao() {
		$settings = new Settings();
		$dsn = $settings->get_db_dsn();
		$dao = new DAO();
		$dao->set_db_dsn($dsn);
		return $dao;
	}
}

?>
