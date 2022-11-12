import smtplib

gmail_user = 'CPTS327WebsiteEmail@gmail.com'
gmail_password = 'SaltedPassword1!'


sent_from = gmail_user
to = ['Sadler_Derek@comcast.net']
subject = 'your email'
body = 'yes'

email_text = """\
From: %s
To: %s
Subject: %s

%s
""" % (sent_from, ", ".join(to), subject, body)

try:
  smtp_server = smtplib.SMTP_SSL('smtp.gmail.com', 465)
  smtp_server.ehlo()
  smtp_server.login(gmail_user, gmail_password)
  
  
except Exception as ex:
  print("Something went wrong..", ex)
