mysqldump -uroot -prayoroot0149 --opt rayodent | gzip > "/home/rayodent/backups/rayodent.$(date +%F_%T).sql.gz" 2> /home/rayodent/backups/dump.log
