<?php
session_start();

function isAdmin() {
    return (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'admin');
}

