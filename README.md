# clean

環境構築手順

#### 1．C:\Users\ユーザー名\product ディレクト作成

#### 2.プロジェクトをクローン
    
    リポジトリ
    https://github.com/ogura-kazuya/hachimaro

    ディレクトリ
    C:/Users/ユーザー名/product/hachimaro

    チェックアウト ブランチ
    develop

#### 3.既にboxファイルが存在した場合
	
	vagrant box remove centos/7


#### 4.boxファイルの追加を行う
    
    ※bush
    cd C:/Users/ユーザー名/product/hachimaro
    
    vagrant box add centos/7 aircle.box

#### 5.boxファイルの確認

    4.でいれたboxがあるか確認
    
    vagrant box list
    
    centos/7
    ↑表示されればok
    
#### 6.既にboxファイルが存在した場合
	
	vagrant box remove centos/7

#### 7.仮想環境を立ち上げる
    
    cd C:/Users/ユーザー名/product/hachimaro
    
    vagrant up

#### 8.localhostへの接続確認
    
    http://192.168.33.10:8080/
    ページが表示されればok

#### 9. ssh接続ができるか確認


    ※bash
    vagrant ssh

    teraterm
    ホスト
    127.0.0.1
    TCP ポート 
    2222
    ユーザー名
    vagrant
    秘密鍵指定
        vagrant ssh-config
            IdentityFile に記載されているkeyを指定
    接続できたらローカル環境構築完了

