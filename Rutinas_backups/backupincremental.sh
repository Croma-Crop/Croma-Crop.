#!/bin/bash
set -uo pipefail
FECHA=$(date +%Y%m%d)
ORIGEN="/datos/produccion"

PROYECTO_DIR="/home/cromacorp/Escritorio/sgrsi-docker"

sudo mkdir -p "$ORIGEN" || exit 1

cd "$PROYECTO_DIR" || exit 1
docker compose exec -T db mysqldump -u root -pcromaroot2026 sgrsi \
  > "$PROYECTO_DIR/Cromapagina/Croma/Datos/DataBase/sgrsi.sql" || exit 1

sudo cp -a /etc/ssh/sshd_config "$ORIGEN" || exit 1
sudo cp -a "$PROYECTO_DIR/docker-compose.yml" "$ORIGEN" || exit 1
sudo cp -a "$PROYECTO_DIR/web" "$ORIGEN" || exit 1
sudo cp -a "$PROYECTO_DIR/Cromapagina/Croma/Procesos" "$ORIGEN" || exit 1
sudo cp -a "$PROYECTO_DIR/Cromapagina/Croma/Datos" "$ORIGEN" || exit 1
sudo cp -a "$PROYECTO_DIR/Cromapagina/Croma/Presentacion" "$ORIGEN" || exit 1

DESTINO_BASE="/mnt/backup/incremental_semidiario"
DESTINO="$DESTINO_BASE/$FECHA"
LOG_FILE="/var/backups/incremental_$FECHA.log"
EXCLUSIONES="/etc/backup/excluir.txt"

sudo mkdir -p "/etc/backup"
sudo mkdir -p "/var/backups"
sudo mkdir -p "$DESTINO_BASE"

if [ ! -f "$EXCLUSIONES" ]; then
  echo "ERROR no existe $EXCLUSIONES" | tee -a "$LOG_FILE"
  exit 1
fi

ULTIMO_BACKUP=$(find "$DESTINO_BASE" /mnt/backup/full_semanal/ -maxdepth 1 -type d -name "20*" -printf "%T@ %p\n" | sort -n | tail -1 | cut -f 2- -d " ")

if [ -z "$ULTIMO_BACKUP" ]; then
  echo "ERROR no se encontro backup anterior." | tee -a "$LOG_FILE"
  exit 1
fi

echo "Ultimo backup encontrado (base para incremental): $ULTIMO_BACKUP" >> "$LOG_FILE"

sudo mkdir -p "$DESTINO" || exit 1

echo "---------INICIO DEL BACKUP incremental $FECHA ---------" >> "$LOG_FILE"

rsync -avh --delete --exclude-from="$EXCLUSIONES" --link-dest="$ULTIMO_BACKUP" "$ORIGEN" "$DESTINO" 2>&1 | tee -a "$LOG_FILE"

RC=${PIPESTATUS[0]}
if [ "$RC" -eq 0 ] || [ "$RC" -eq 24 ]; then
  echo "BACKUP INCREMENTAL FINALIZADO CON EXITO." | tee -a "$LOG_FILE"
  RESULTADO=0
else
  echo "ERROR: Fallo en el desarrollo del backup incremental." | tee -a "$LOG_FILE"
  RESULTADO=1
fi

echo "FIN DE BACKUP INCREMENTAL $FECHA ---" >> "$LOG_FILE"

find "$DESTINO_BASE" -maxdepth 1 -type d -name "20*" -mtime +14 -exec rm -rf {} +

exit $RESULTADO
