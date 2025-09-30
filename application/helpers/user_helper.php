<?php

	function isadmin() {
		$ci = get_instance();
		$level = $ci->session->userdata('role');
		if ($level != 'admin maintenance') {
			redirect('auth');
		}
	}

	function isteknisi() {
		$ci = get_instance();
		$level = $ci->session->userdata('role');
		if ($level != 'teknisi') {
			redirect('auth');
		}
	}

	function issupir() {
		$ci = get_instance();
		$level = $ci->session->userdata('role');
		if ($level != 'supir') {
			redirect('auth');
		}
	}