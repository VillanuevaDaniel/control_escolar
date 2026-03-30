<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Boleta - <?php echo e($alumno['matricula']); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 13px;
            margin: 40px;
            color: #333;
            line-height: 1.5;
        }

        .boleta-outer {
            border: 2px solid #000;
            padding: 30px;
            border-radius: 4px;
            box-shadow: inset 0 0 0 4px #fff, inset 0 0 0 6px #000;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .school-name {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 5px;
            color: #000;
            text-transform: uppercase;
        }

        .doc-title {
            font-size: 16px;
            font-weight: bold;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            display: inline-block;
            padding: 5px 20px;
            margin-top: 10px;
        }

        .info-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }

        .promedio-row {
            font-size: 18px;
            font-weight: 800;
            text-align: right;
            margin-top: 10px;
            border-bottom: 4px double #000;
            display: block;
            padding-bottom: 5px;
        }

        .footer-signatures {
            margin-top: 70px;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 30px;
        }

        .sig-line {
            border-top: 1px solid #000;
            text-align: center;
            padding-top: 8px;
            font-size: 11px;
            font-weight: bold;
        }

        .no-print {
            margin-bottom: 15px;
            text-align: right;
        }

        .status-pass {
            color: #166534;
            font-weight: bold;
        }

        .status-fail {
            color: #991b1b;
            font-weight: bold;
        }

        @media print {
            .no-print {
                display: none;
            }

            .boleta-outer {
                border: 2px solid #000;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <div class="no-print">
        <button onclick="window.print();" style="padding:10px 20px; cursor:pointer; background:#10b981; color:white; border:none; border-radius:4px; font-weight:bold;">Imprimir Boleta</button>
        <button onclick="window.close();" style="padding:10px 20px; cursor:pointer; background:#64748b; color:white; border:none; border-radius:4px; font-weight:bold;">Cerrar</button>
    </div>

    <div class="boleta-outer">
        <div class="header">
            <div class="school-name">COLEGIO CONTROL ESCOLAR PHP</div>
            <div class="doc-title">BOLETA OFICIAL DE CALIFICACIONES</div>
        </div>

        <div class="info-section">
            <div>
                <strong>ALUMNO:</strong> <?php echo e($alumno['apellido_paterno'] . ' ' . $alumno['apellido_materno'] . ' ' . $alumno['nombre']); ?><br>
                <strong>MATRÍCULA:</strong> <?php echo e($alumno['matricula']); ?><br>
                <strong>CURP:</strong> <?php echo e($alumno['curp']); ?>
            </div>
            <div style="text-align: right;">
                <strong>GRUPO:</strong> <?php echo e($grupo ? $grupo['nombre'] : 'S/G'); ?><br>
                <strong>GRADO:</strong> <?php echo e($alumno['grado'] ?: '—'); ?>°<br>
                <strong>FECHA DE EMISIÓN:</strong> <?php echo date('d/m/Y'); ?>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ASIGNATURA / MATERIA</th>
                    <th style="width: 120px; text-align: center;">CALIFICACIÓN</th>
                    <th style="width: 160px; text-align: center;">VALORACIÓN</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$calificaciones): ?>
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 30px;">No se registran calificaciones para el alumno en el ciclo actual.</td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($calificaciones as $c): ?>
                    <tr>
                        <td style="font-weight: 600;"><?php echo e($c['materia']); ?> <br><small><?php echo e($c['etiqueta_periodo'] ?? ''); ?></small></td>
                        <td style="text-align: center; font-size: 16px; font-weight: 800;"><?php echo number_format($c['puntaje'], 1); ?></td>
                        <td style="text-align: center; font-size: 11px;">
                            <?php if ($c['puntaje'] >= 6): ?>
                                <span class="status-pass">ACREDITADA</span>
                            <?php else: ?>
                                <span class="status-fail">NO ACREDITADA</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="promedio-row">
            PROMEDIO FINAL: <?php echo number_format($promedio, 2); ?>
        </div>

        <div class="footer-signatures">
            <div class="sig-line">DIRECCIÓN TÉCNICA</div>
            <div class="sig-line">SELLO INSTITUCIONAL</div>
            <div class="sig-line">FIRMA DEL PADRE/TUTOR</div>
        </div>

        <div style="margin-top: 30px; text-align: center; font-size: 10px; color: #666;">
            Esta boleta tiene validez oficial únicamente con el sello original de la institución.
        </div>
    </div>
</body>

</html>