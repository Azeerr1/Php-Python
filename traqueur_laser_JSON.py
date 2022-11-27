from pickle import FALSE, TRUE
import cv2
import numpy as np

def nothing(x):
    pass

triangle = 0
cap = cv2.VideoCapture('http://test:test@192.168.1.88:8080/video')
detection = FALSE
cv2.namedWindow("Trackbars")


cv2.namedWindow("Frame", cv2.WINDOW_NORMAL)
cv2.resizeWindow("Frame", 1200, 900)

cv2.createTrackbar("Low-H", "Trackbars", 20, 180, nothing)
cv2.createTrackbar("Low-S", "Trackbars", 117, 255, nothing)
cv2.createTrackbar("Low-V", "Trackbars", 0, 255, nothing)
cv2.createTrackbar("Upp-H", "Trackbars", 180, 180, nothing)
cv2.createTrackbar("Upp-S", "Trackbars", 255, 255, nothing)
cv2.createTrackbar("Upp-V", "Trackbars", 255, 255, nothing)

font = cv2.FONT_HERSHEY_COMPLEX

while detection == FALSE:
    _, frame = cap.read()
    hsv = cv2.cvtColor(frame, cv2.COLOR_BGR2HSV)

    l_h = cv2.getTrackbarPos("Low-H", "Trackbars")
    l_s = cv2.getTrackbarPos("Low-S", "Trackbars")
    l_v = cv2.getTrackbarPos("Low-V", "Trackbars")
    u_h = cv2.getTrackbarPos("Upp-H", "Trackbars")
    u_s = cv2.getTrackbarPos("Upp-S", "Trackbars")
    u_v = cv2.getTrackbarPos("Upp-V", "Trackbars")

    lower_red = np.array([l_h, l_s, l_v])
    upper_red = np.array([u_h, u_s, u_v])

    mask = cv2.inRange(hsv, lower_red, upper_red)
    kernel = np.ones((5, 5), np.uint8)
    mask = cv2.erode(mask, kernel)

    pts = []
    ret, frame = cap.read()
    hsv = cv2.cvtColor(frame, cv2.COLOR_BGR2HSV)


    lower_red = np.array([160,40,255])
    upper_red = np.array([280,255,255])
    mask0 = cv2.inRange(hsv, lower_red, upper_red)
    (minVal, maxVal, minLoc, maxLoc) = cv2.minMaxLoc(mask0)
    if maxLoc[0] > 0:
        cv2.circle(frame, maxLoc, 20, (255, 255, 50), 3, cv2.LINE_AA)
        cv2.putText(frame, str(maxLoc), (maxLoc), font, 1, (0, 0, 0))

    contours, _ = cv2.findContours(mask, cv2.RETR_TREE, cv2.CHAIN_APPROX_SIMPLE)



    for cnt in contours:
        area = cv2.contourArea(cnt)
        approx = cv2.approxPolyDP(cnt, 0.02*cv2.arcLength(cnt, True), True)
        x = approx.ravel()[0]
        y = approx.ravel()[1]

        if area > 400:
            cv2.drawContours(frame, [approx], 0, (0, 0, 0), 3)

            if len(approx) == 3:
                cv2.putText(frame, "  x: " + str(x) + " y: " + str(y), (x, y), font, 1, (0, 0, 0))
                triangle = triangle + 1

    cv2.imshow("Frame", frame)

    if cv2.waitKey(1) & 0xFF == ord('q'):
       break

    test = str(maxLoc)

    if triangle == 1:
        x1 = str(x)
        y1 = str(y)

    if triangle == 2:
        x2 = str(x)
        y2 = str(y)

    if triangle == 3:
        x3 = str(x)
        y3 = str(y)

    if triangle == 4:
        x4 = str(x)
        y4 = str(y)

        centrex = (int(x1) + int(x2) + int(x3) + int(x4))/4
        centrey = (int(y1) + int(y2) + int(y3) + int(y4))/4
        centre = centrex, centrey

        if str(maxLoc) == centre:
            print("+10 points !")

if maxLoc[0]>0:
    detection = TRUE

cap.release()
cv2.destroyAllWindows()

if detection == TRUE:
    import json

    Joueurs = {
        "Coordonnes" : str(maxLoc),
    }

    with open('data.json', 'w') as joueur:
        json.dump(Joueurs, joueur)
        
        