<?php

function registrarErrorBD(Throwable $e, string $operacion): bool {
    error_log("Croma - fallo en " . $operacion . ": " . $e->getMessage());
    return false;
}
