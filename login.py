import base64
import json
import sys
import requests
from Crypto.Cipher import PKCS1_v1_5
from Crypto.PublicKey import RSA

try:
    username = sys.argv[1]  # 教务系统账号
    password = sys.argv[2]  # 教务系统密码 明文
    session = requests.Session()
    session.get("http://jwgl.bzmc.edu.cn/jwglxt/xtgl/login_slogin.html")
    getPublicKey = session.get("http://jwgl.bzmc.edu.cn/jwglxt/xtgl/login_getPublicKey.html")
    getPublicKey_json = getPublicKey.json()
    modulus_b64 = str(getPublicKey_json["modulus"]).replace("/", "\/")
    exponent_b64 = getPublicKey_json["exponent"]
    modulus_bytes = base64.b64decode(modulus_b64)
    exponent_bytes = base64.b64decode(exponent_b64)
    rsa_key = RSA.construct(
        (int.from_bytes(modulus_bytes, byteorder='big'), int.from_bytes(exponent_bytes, byteorder='big')))
    cipher = PKCS1_v1_5.new(rsa_key)


    ciphertext = cipher.encrypt(password.encode())
    encrypted_password_b64 = base64.b64encode(ciphertext).decode()
    data = {
        'csrftoken': '',
        'yhm': username,
        'mm': encrypted_password_b64,
        'mm': encrypted_password_b64
    }
    get = session.post("http://jwgl.bzmc.edu.cn/jwglxt/xtgl/login_slogin.html", data=data)

    if "用户名或密码不正确" in get.text:
        print('用户名或密码不正确')
        exit()

    res = session.get("http://jwgl.bzmc.edu.cn/jwglxt/xsxxxggl/xsgrxxwh_cxXsgrxx.html?gnmkdm=N100801&layout=default")

    print(json.dumps(session.cookies.get_dict()))
except Exception as exception:
    print('false')
