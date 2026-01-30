sudo nano /etc/nginx/sites-available/apex.odiousodds.xyz

server {
listen 80;
listen [::]:80;

        root /var/www/html/apex/current;
        index index.php index.html index.htm index.nginx-debian.html;

        server_name apex.odiousodds.xyz;

        location / {
                try_files $uri $uri/ /index.php?$query_string;
        }

        location ~ \.php$ {
                include snippets/fastcgi-php.conf;

                fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
                fastcgi_param DOCUMENT_ROOT $realpath_root;

                fastcgi_pass unix:/run/php/php8.4-fpm.sock;

        }

        location ~ /\.ht {
                deny all;
        }

}

sudo ln -s /etc/nginx/sites-available/apex.odiousodds.xyz /etc/nginx/sites-enabled/

sudo nginx -t
sudo systemctl restart nginx

sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d apex.odiousodds.xyz
