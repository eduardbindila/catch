# syntax=docker/dockerfile:1
# EN: B2B app image built from your existing hardened base.
FROM harbor.icatch.ro/ice/ice-setup-b2b:7.4

# EN: Working directory used by the base image
WORKDIR /var/www/html

# EN: Copy the B2B source into the image
COPY . /var/www/html

# EN: Make sure uploads exist; still mount a named volume at runtime
RUN mkdir -p /var/www/html/uploads \
    && chown -R www-data:www-data /var/www/html

# EN: The base image already exposes and runs Apache/PHP
