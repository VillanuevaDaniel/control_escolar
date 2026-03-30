<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Grupo - <?php echo e($grupo['nombre']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 30px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin: 0 0 5px 0;
        }

        .subtitle {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info-bar {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            font-weight: bold;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-size: 11px;
            text-transform: uppercase;
        }

        .text-center {
            text-align: center;
        }

        .no-print {
            margin-bottom: 20px;
            text-align: right;
        }

        @media print {
            .no-print {
                display: none;
            }
        }

        .signatures {
            margin-top: 80px;
            display: flex;
            justify-content: space-around;
        }

        .sig-box {
            border-top: 1px solid #000;
            width: 220px;
            text-align: center;
            padding-top: 6px;
            font-weight: bold;
        }
    </style>
</head>

<body onload="/*window.print()*/">
    <div class="no-print">
        <button onclick="window.print();" style="padding:10px 20px; cursor:pointer; background:#197fe6; color:white; border:none; border-radius:4px; font-weight:bold;">Imprimir Reporte</button>
        <button onclick="window.close();" style="padding:10px 20px; cursor:pointer; background:#64748b; color:white; border:none; border-radius:4px; font-weight:bold;">Cerrar Ventana</button>
    </div>

    <div class="header">
        <div class="title">SISTEMA CONTROL ESCOLAR</div>
        <div class="subtitle">Lista Oficial de Alumnos</div>

        <div class="info-bar">
            <span>GRUPO: <?php echo e($grupo['nombre']); ?></span>
            <span>FECHA: <?php echo date('d/m/Y H:i'); ?></span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 35px;" class="text-center">#</th>
                <th style="width: 100px;">MATRÍCULA</th>
                <th>NOMBRE COMPLETO DEL ALUMNO</th>
                <th style="width: 80px;" class="text-center">SEXO</th>
                <th style="width: 180px;">OBSERVACIONES / FIRMA</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!$alumnos): ?>
                <tr>
                    <td colspan="5" class="text-center py-4">No se han encontrado alumnos asignados a este grupo.</td>
                </tr>
            <?php endif; ?>
            <?php $i = 1;
            foreach ($alumnos as $al): ?>
                <tr>
                    <td class="text-center"><?php echo $i++; ?></td>
                    <td><strong><?php echo e($al['matricula']); ?></strong></td>
                    <td><?php echo e($al['apellido_paterno'] . ' ' . $al['apellido_materno'] . ' ' . $al['nombre']); ?></td>
                    <td class="text-center"><?php echo e($al['genero'] === 'M' ? 'Hombre' : 'Mujer'); ?></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="signatures">
        <div class="sig-box">
            Sello de la Institución
        </div>
        <div class="sig-box">
            Firma del Docente / Director
        </div>
    </div>
</body>

</html>