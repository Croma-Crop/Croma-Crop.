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
sudo cp -a "$PROYECTO_DIR/Cromapagina/Croma/Presentacion" "$ORIGEN" || exit 1
sudo cp -a "$PROYECTO_DIR/Cromapagina/Croma/Procesos" "$ORIGEN" || exit 1
sudo cp -a "$PROYECTO_DIR/Cromapagina/Croma/Datos" "$ORIGEN" || exit 1

RUTA_EXTERNA=$(lsblk -rno MOUNTPOINT,RM | awk '$2=="1" && $1!="" {print $1; exit}')
LOG_FILE="/var/log/backup/full_$FECHA.log"
EXCLUSIONES="/etc/backup/excluir.txt"
sudo mkdir -p "/var/log/backup"

if [ -z "$RUTA_EXTERNA" ]; then
  echo "Error no hay dispositivo externo conectado."
  exit 1
fi

if [ ! -f "$EXCLUSIONES" ]; then
  echo "Error no existe $EXCLUSIONES"
  exit 1
fi

DESTINO="${RUTA_EXTERNA}/mnt/backup/full_semanal/${FECHA}"
sudo mkdir -p "$DESTINO" || exit 1

echo "---------INICIO DEL BACKUP-----------" | sudo tee -a "$LOG_FILE" >/dev/null
echo "Origen: $ORIGEN" | sudo tee -a "$LOG_FILE" >/dev/null
echo "Destino: $DESTINO" | sudo tee -a "$LOG_FILE" >/dev/null

sudo rsync -rlvh --no-perms --no-owner --no-group --delete --exclude-from="$EXCLUSIONES" "$ORIGEN" "$DESTINO" 2>&1 | sudo tee -a "$LOG_FILE"

if [ "$?" -eq 0 ]; then
  echo "BACKUP COMPLETO FINALIZADO CON EXITO." | sudo tee -a "$LOG_FILE"
  RESULTADO=0
else
  echo "ERROR: Fallo en el desarrollo del backup completo." | sudo tee -a "$LOG_FILE"
  RESULTADO=1
fi

echo "FIN DE BACKUP COMPLETO $FECHA ---" | sudo tee -a "$LOG_FILE" >/dev/null

find "${RUTA_EXTERNA}/mnt/backup/full_semanal" -maxdepth 1 -type d -name "20*" -mtime +21 -exec rm -rf {} +

exit $RESULTADO
