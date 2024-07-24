#!/bin/bash

#Скрипт для создание папки, и работы супервизора

# Путь к директории, в которой должен находиться лог
LOG_DIR="/home/supervisor_log/app.com"

# Проверка на существование директории, при необходимости создание
if [ ! -d "$LOG_DIR" ]; then
    mkdir -p "$LOG_DIR"
fi

# Запуск вашего PHP worker (замените на вашу команду)
# php /path/to/your/worker/script.php >> "$LOG_DIR/worker.log" 2>&1

