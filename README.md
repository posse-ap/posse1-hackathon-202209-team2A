## ハッカソン202209

### ビルド

.env.developmentをルートディレクトリに作成して、.env.exampleの内容をコピーしてください。
トークンなどの情報はslack channnel '20220906-2a'に記載しているので、そちらを.env.developmentにペーストください

ディレクトリに移動して以下のコマンドを実行してください

```bash
docker-compose build --no-cache
docker-compose up -d
```

### 動作確認

ブラウザで `http://localhost` にアクセスして、正しく画面が表示されているか確認してください

### メール送信について

メール送信
phpコンテナにて./modules/notificationに移動して、各ファイルを実行ください。

メール受信
ブラウザで `http://localhost:8025/` にアクセスしてください、メールボックスが表示されます


### slack通知について

slack受信先
以下のworkspaceに入室いただき、「hackathon」というチャンネルに入室ください。

slack送信
phpコンテナにて./modules/notification/slackに移動して、各ファイルを実行ください。
