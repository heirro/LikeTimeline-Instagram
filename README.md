# Welcome pada v2 cara gunainnya?
# Upload di hosting mu

1. http://domainkamu/account.php?id=USERNAMEIGKAMU&pw=PASSWORDIGKAMU
2. account.php filenya
3. ?id = parameter username instagram kamu
4. ?pw = parameter password instagram kamu.

- Untuk yang tidak punya hosting bisa gunain API milik saya, server and load-balancing by CloudFlare.
- Script ini tanpa LOG/Phising dan semacamnya, 100% aman. Parameter hanya API Token login.

* Cron Job 15 menit atau 30 menit biar aman.
* Jika kebanned bukan tanggung jawab saya.
* Follow https://www.instagram.com/heirrok/ , saya juga pakai API ini, bisa test sendiri.

# Untuk CronJob bisa Pakai Google Drive

* function cronExecute() {
*    var url = "https://api.heirro.net/apps/ig/tllike/?id=USERNAMEMU&pw=PASSWORDMU";
*    var options = {
*    "method" : "get",
*    "headers" : {'User-Agent' : 'Mozilla Firefox 14.0',
*    'Accept-Charset' : 'ISO-8859-1,utf-8;q=0.7,*;q=0.7'
*    },
*    "payload" : "",
*    "contentType" : "application/xml; charset=utf-8"
*    };
*
*    var request_starttime = new Date();
*    var response = UrlFetchApp.fetch(url,options);
*    var request_endtime = new Date();
*    }
