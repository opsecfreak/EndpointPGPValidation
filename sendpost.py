import requests
import gnupg

def send_post_request():
    gpg = gnupg.GPG()

    # Load the public key
    with open("public-key.asc", "r") as f:
        public_key = f.read()
    import_result = gpg.import_keys(public_key)

    # Your data and encryption
    data = "This is a test message."
    encrypted_data = str(gpg.encrypt(data, import_result.fingerprints[0]))

    # POST request
    url = "https://DOMAIN.com/postfile.php"
    headers = {
        "User-Agent": "user-agent-specialkey",
        # Authorization is set to 1, however it can be modified to specify the machine identifier, a unique key, and more. 
        "Authorization": "1", 
    }
    payload = {
        "data": encrypted_data
    }
    response = requests.post(url, headers=headers, data=payload)

    print(response.text)

if __name__ == "__main__":
    send_post_request()
