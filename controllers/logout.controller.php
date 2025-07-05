<?php

session_destroy();
header('Location: /login');
exit(); // a função exit() é importante para garantir que o script pare de ser executado após o redirecionamento