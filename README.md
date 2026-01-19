# 📡 Selenium + WebSocket Automation Server

A Node.js-based automation server that integrates **Selenium WebDriver** with **WebSocket communication**.

The program listens for **WebSocket signals**, and upon receiving commands, it uses Selenium to **navigate web pages** and **retrieve or display information in real time**.

This architecture is suitable for remote browser control, monitoring tools, automated testing, or assisted web automation services.

---

## ✨ Features

* 🔌 Runs a WebSocket server
* 📥 Receives commands via WebSocket messages
* 🌐 Controls and navigates web pages using Selenium
* 🔍 Extracts and processes page information
* ⚡ Real-time, event-driven browser automation

---

## 🧱 Tech Stack

* **Node.js**
* **Selenium WebDriver**
* **WebSocket (ws)**
* Chrome / Chromium (or Firefox)

---

## 🚀 Getting Started

### 1. Install Dependencies

```bash
npm install
```

OR (또는)

```bash
yarn install
```

---

### 2. Configure environment variables

```bash
cp .env.example .env
vim .env  <=  edit it, your environment 
```

---

### 3. Prepare Browser for Selenium

* Install Chrome / Chromium (or Firefox)
* Ensure the WebDriver version matches the browser version

### 4. Run the Server

```bash
node index.js
```

---

## 🔁 How It Works

1. Start the server and wait for WebSocket connections
2. A client sends a command via WebSocket
3. The server receives and parses the command
4. Selenium performs the requested browser action (e.g., navigation)
5. Required data is extracted or the action is executed
6. The result is returned via WebSocket or logged

---

## 🧪 Example WebSocket Messages

```json
{
  "action": "navigate",
  "url": "https://example.com"
}
```

```json
{
  "action": "getText",
  "selector": "#content"
}
```

---

## 📄 License

MIT License
