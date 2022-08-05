rsync -avz --no-perms --omit-dir-times --progress --delete --exclude '.htaccess' --exclude '.git' --exclude '.DS_Store' --exclude '.vscode' --exclude 'node_modules/' --exclude 'uploads/*' --exclude 'quotes/*' --exclude 'cache/*' --exclude 'deploy-staging.sh' --exclude 'deploy-vpn.sh' it-jlcoccoz@webdev.cooperacionseguros.com.ar:/srv/www/vhosts/wordpress/wp-content/themes/cooperacionseguros-theme/ /srv/www/vhosts/wordpress/wp-content/themes/cooperacionseguros-theme

# chgrp -R www /srv/www/vhosts/wordpress/wp-content/themes/cooperacionseguros-theme
find /srv/www/vhosts/wordpress/wp-content/themes/cooperacionseguros-theme -user it-jlcoccoz -exec chgrp www {} \;
# chmod -R g+rw /srv/www/vhosts/wordpress/wp-content/themes/cooperacionseguros-theme
find /srv/www/vhosts/wordpress/wp-content/themes/cooperacionseguros-theme -user it-jlcoccoz -exec chmod g+rw {} \;

