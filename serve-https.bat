php -S 192.168.1.33:8000 -t public/ \
    -d openssl.cafile=server.crt \
    -d openssl.capath=server.key