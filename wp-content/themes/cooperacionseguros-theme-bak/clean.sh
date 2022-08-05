# Definir los días para limpiar archivos o usar el valor por defecto
default=30
value=${1:-$default}

# Borrar quotes con más de X días
echo "Borrando quotes con más de $value días:"
find quotes/ -name "*.json" -type f -mtime +$value -exec rm -vrf {} \; | echo "$(wc -l) quotes borrados"

# Borrar uploads con más de X días
echo "Borrando uploads con más de $value días:"
find uploads/ -name "*.jpg" -type f -mtime +2 -exec rm -vrf {} \; | echo "$(wc -l) uploads borrados"
