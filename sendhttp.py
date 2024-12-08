import requests

def send_request(url):
    try:
        response = requests.get(url)
        response.raise_for_status()  # Raise an error for bad status codes
        print(f"Response from server: {response.text}")
    except requests.exceptions.RequestException as e:
        print(f"An error occurred: {e}")

if __name__ == "__main__":
    url = "http://qat-pi-3.friendsbalt.org"  # Replace with your LAMP server URL
    send_request(url)