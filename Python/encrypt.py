import bcrypt

def getSalt():
  salt = bcrypt.gensalt()
  return salt

def setHash(password, salt):
  hashPassword = bcrypt.hashpw(password, salt)
  return (hashPassword)

def decrypt(password, hashed_password):
  check = bcrypt.checkpw(password, hashed_password)
  return check

s = (setHash(b"pass", getSalt()))
decrypt(b"pass", s)

