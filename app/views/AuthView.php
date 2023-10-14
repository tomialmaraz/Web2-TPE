<?php

class AuthView {
                    // por que Franco metido esta variable "$error"? lo dijo pero no me acuerdo
    function showLogin($error = null) {
        require './templates/Login.phtml';
    }
}