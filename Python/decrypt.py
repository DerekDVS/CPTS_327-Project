def decrypt(password, hashed_password):
  check = bcrypt.checkpw(password, hashed_password)
  return check
