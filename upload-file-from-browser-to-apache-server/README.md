## Pre-requisites:
1. Linux instance
2. Browser

## Step 1: Install apache and php on RHEL server

- Install the httpd, php and php-fpm module:
```sh
yum install httpd php php-fpm -y
```

- Start the httpd and php-fpm service:
```sh
systemctl restart httpd php-fpm
```

- Enable both services to start at boot time:
```sh
systemctl enable php-fpm httpd
```


## Step 2: To try if apache and php are configred try below command

- To obtain information about your PHP settings, create the index.php file with the following content in the /var/www/html/ directory:
```sh
echo '<?php phpinfo(); ?>' > /var/www/html/index.php
```

- To run the index.php file, point the browser to:
```sh
http://<hostname>/
```



## Step 3:  Create simlink for extensions folder and scripts folder in /var/www/html
```sh
cd /var/www/html
ln -s /opt/polarion/polarion/extensions extensions
ln -s /opt/polarion/scripts/ scripts
```

## Step 4: Create a upload.php file and copy the php code prsent in repo.
```sh
cd /var/www/html
touch upload.php
#Paste the upload.php file content from repo to above file in server
```
## Step 5: Access the http://<hostname>/upload.php and try uploading files to server.


#### Note:
1- Not able to upload file to server: Check the apache logs in /var/log/html/error_log for error messages. You need to changes folder permissions to accomplish this.

2- If want to change the destincation folder location, change the the name of simlinks created in step 3 with your directory location. Change options value in the update.php
ex: 
```sh
ln -s /opt opt
ln -s /opt/kits kits
```
```html
<option value="opt">/OPT</option>
<option value="kits">Kits</option>
```



#### Ref Links: 
- [Apache and PHP configuration for RHEL](https://access.redhat.com/documentation/en-us/red_hat_enterprise_linux/8/html/configuring_basic_system_settings/using-the-php-scripting-language_configuring-basic-system-settings)
