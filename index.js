import http from 'http';
import { server as WebSocketServer } from 'websocket';
import { remote } from 'webdriverio';
import dotenv from 'dotenv';

dotenv.config(); // .env 로드

const url = process.env.URL;
const webSocketsServerPort = process.env.PORT || 8080;
let browser;

// --- 브라우저 시작 ---
(async () => {
/* browser = await remote({
  logLevel: 'info',
  protocol: 'http',
  hostname: 'localhost',
  port: 9515,
  path: '/',
  capabilities: {
    browserName: 'chrome'
  }
}); */
browser = await remote({
  logLevel: 'info',
  capabilities: {
    browserName: 'chrome',
  },
});

    await browser.url(url);
    await browser.maximizeWindow();

    const loginId = await browser.$('#login_id');
    await loginId.setValue(process.env.LOGIN_ID);

    const loginPwd = await browser.$('#login_password');
    await loginPwd.setValue(process.env.LOGIN_PASSWORD);

    const loginBtn = await browser.$('.btn_login');
    await loginBtn.click();
})();

// --- WebSocket 서버 설정 ---
const server = http.createServer(() => {});
server.listen(webSocketsServerPort, "0.0.0.0", () => {
    console.log(`Server is listening on port ${webSocketsServerPort}`);
});

const socket = new WebSocketServer({
    httpServer: server,
    autoAcceptConnections: false
});

// --- WebSocket 메시지 처리 ---
socket.on('request', (request) => {
    const connection = request.accept(null, request.origin);

    connection.on('message', async (message) => {
        await browser.url(url + '/home/?search_type=field&search_field=phone&show_count=true&search_word='+message.utf8Data);
    });
});
