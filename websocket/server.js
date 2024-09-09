const WebSocket = require("ws");

const wss = new WebSocket.Server({ port: 8000 });
const jwt = require("jsonwebtoken");
const secretKey = "secretKey";

const channels = {};

function subscribeToChannel(ws, channel) {
  if (!channels[channel]) {
    channels[channel] = new Set();
  }

  channels[channel].add(ws);
}

function unsubscribeFromChannel(ws, channel) {
  if (channels[channel]) {
    channels[channel].delete(ws);

    console.log(`unsubscribeFromChannel: ${ws} ${channel}`);

    if (channels[channel].size === 0) {
      delete channels[channel];
    }
  }
}

function broadcastMessageToChannel(channel, msg) {
  if (channels[channel]) {
    channels[channel].forEach((client) => {
      if ((client.readyState = WebSocket.OPEN)) {
        client.send(msg);
      }
    });
  }
}

wss.on("connection", (ws, request) => {
  const searchParams = new URLSearchParams(request.url.split("?")[1]);
  const token = searchParams.get("token");

  try {
    const decoded = jwt.verify(token, secretKey);
    console.log(decoded);
    ws.on("message", (data) => {
      console.log("new message %s", data.toString());
    });

    ws.on("close", (code, reason) => {
      console.log("client closed", code, reason);
    });
  } catch {}
});

console.log("WebSocket is running at ws://localhost:8000");
