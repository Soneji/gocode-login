# Derived from official mysql image (our base image)
FROM mariadb:10.4.11

# Add a database
ENV MYSQL_DATABASE gocode

# Add the content of the sql-scripts/ directory to your image
# All scripts in docker-entrypoint-initdb.d/ are automatically
# executed during container startup
COPY ./database_format.sql /docker-entrypoint-initdb.d/
