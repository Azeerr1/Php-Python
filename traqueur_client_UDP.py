import socket, sys

HOST = '192.168.1.27'
PORT = 1845

mySocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
mySocket.bind((HOST, PORT))
print("Connexion établie avec le serveur")
msgServeur = mySocket.recv(1024).decode("Utf8")

while(1):
    print("Serveur :",msgServeur)
    msgClient = input("Client :")
    mySocket.send(msgClient.encode("Utf8"))
    msgServeur = mySocket.recv(1024).decode("Utf8")
    print("Connexion interrompue")
mySocket.close()

