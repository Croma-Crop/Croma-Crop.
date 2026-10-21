#!/bin/bash
set -o pipefail
FECHA=$(date +%Y%m%d)
ORIGEN="/datos/produccion"


PROYECTO_DIR="/home/cromacorp/Escritorio/sgrsi-docker"

sudo mkdir -p "$ORIGEN"

sudo cd "$PROYECTO_DIR" || exit 1
docker compose exec -T db mysqldump -u root -pcromaroot2026 sgrsi \
  > "$PROYECTO_DIR/Cromapagina/Croma/Datos/DataBase/sgrsi.sql" || exit 1

sudo cp -r /etc/ssh/sshd_config "$ORIGEN"
sudo cp -r "$PROYECTO_DIR/docker-compose.yml" "$ORIGEN"
sudo cp -r "$PROYECTO_DIR/web" "$ORIGEN"
sudo cp -r "$PROYECTO_DIR/Cromapagina/Croma/Procesos" "$ORIGEN"
sudo cp -r "$PROYECTO_DIR/Cromapagina/Croma/Datos" "$ORIGEN"
sudo cp -r "$PROYECTO_DIR/Cromapagina/Croma/Presentacion" "$ORIGEN"

DESTINO="/mnt/backup/full_semanal/$FECHA"
LOG_FILE="/var/log/backup/full_$FECHA.log"
EXCLUSIONES="/etc/backup/excluir.txt"

sudo mkdir -p "$DESTINO"
sudo mkdir -p /var/log/backup

echo "---------INICIO DEL BACKUP-----------" >> "$LOG_FILE"
echo "Origen: $ORIGEN" >> "$LOG_FILE"
echo "Destino: $DESTINO" >> "$LOG_FILE"

rsync -avh --delete --exclude-from="$EXCLUSIONES" "$ORIGEN" "$DESTINO" 2>&1 | tee -a "$LOG_FILE"

if [ "${PIPESTATUS[0]}" -eq 0 ]; then
  echo "BACKUP COMPLETO FINALIZADO CON EXITO." | tee -a "$LOG_FILE"
else
  echo "ERROR: Fallo en el desarrollo del backup completo." | tee -a "$LOG_FILE"
fi

echo "FIN DE BACKUP COMPLETO $FECHA ---" >> "$LOG_FILE"

find "/mnt/backup/full_semanal" -maxdepth 1 -type d -name "20*" -mtime +21 -exec rm -rf {} +
