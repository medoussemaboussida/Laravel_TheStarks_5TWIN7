// Mailing functions
def success() {
    def imageUrl = 'https://semaphoreci.com/wp-content/uploads/2020/02/cic-cd-explained.jpg'
    def imageWidth = '800px'
    def imageHeight = 'auto'

    echo "Sending success email..."
    emailext(
        body: """
        <html>
        <body>
            <p>The Jenkins job was successful.</p>
            <p>You can view the build at: <a href="${BUILD_URL}">${BUILD_URL}</a></p>
            <p><img src="${imageUrl}" alt="Your Image" width="${imageWidth}" height="${imageHeight}"></p>
        </body>
        </html>
        """,
        subject: "Jenkins Build - Success",
        to: 'medoussemaboussida@gmail.com',
        from: 'medoussemaboussida@gmail.com',
        replyTo: 'medoussemaboussida@gmail.com',
        mimeType: 'text/html'
    )
    echo "Success email sent."
}

def failure() {
    def imageUrl = 'https://miro.medium.com/v2/resize:fit:4800/format:webp/1*ytlj68SIRGvi9mecSDb52g.png'
    def imageWidth = '800px'
    def imageHeight = 'auto'

    echo "Sending failure email..."
    emailext(
        body: """
        <html>
        <body>
            <p>Oops! The Jenkins job Failed.</p>
            <p>You can view the build at: <a href="${BUILD_URL}">${BUILD_URL}</a></p>
            <p><img src="${imageUrl}" alt="Your Image" width="${imageWidth}" height="${imageHeight}"></p>
        </body>
        </html>
        """,
        subject: "Jenkins Build - Failure",
        to: 'medoussemaboussida@gmail.com',
        from: 'medoussemaboussida@gmail.com',
        replyTo: 'medoussemaboussida@gmail.com',
        mimeType: 'text/html'
    )
    echo "Failure email sent."
}

pipeline {
    agent any
    stages {
        stage('Checkout GIT') {
            steps {
                echo 'Pulling ...'
                git branch: 'main',
                    url: 'https://github.com/medoussemaboussida/Laravel_TheStarks_5TWIN7.git'
            }
        }
        stage('Setup SonarScanner') {
            steps {
                sh '''
                    # Clean previous ZIP files to avoid duplicates
                    rm -f sonar-scanner-cli-7.3.0.5189-linux-x64.zip*
                    
                    # Check if Java is available; if not, download portable Adoptium JDK 17
                    if ! command -v java &> /dev/null; then
                        echo "Java not found, downloading portable JDK 17..."
                        wget https://github.com/adoptium/temurin17-binaries/releases/download/jdk-17.0.12%2B7/OpenJDK17U-jre_x64_linux_hotspot_17.0.12_7.tar.gz
                        tar -xzf OpenJDK17U-jre_x64_linux_hotspot_17.0.12_7.tar.gz
                        export JAVA_HOME=$(pwd)/jdk-17.0.12+7
                        export PATH=$JAVA_HOME/bin:$PATH
                    fi
                    
                    # Download SonarScanner CLI to workspace (force overwrite with -O)
                    wget -O sonar-scanner-cli-7.3.0.5189-linux-x64.zip https://binaries.sonarsource.com/Distribution/sonar-scanner-cli/sonar-scanner-cli-7.3.0.5189-linux-x64.zip
                    
                    # Extract using Python (since unzip may not be available)
                    python3 -c "
import zipfile
with zipfile.ZipFile('sonar-scanner-cli-7.3.0.5189-linux-x64.zip', 'r') as zip_ref:
    zip_ref.extractall('.')
"
                    
                    # Verify (using local Java if downloaded)
                    ./sonar-scanner-7.3.0.5189-linux/bin/sonar-scanner -h
                '''
            }
        }
        stage("SonarQube Analysis") {
            steps {
                withSonarQubeEnv('scanner') {
                    sh './sonar-scanner-7.3.0.5189-linux/bin/sonar-scanner'
                }
            }
        }
        stage('Start Prometheus') {
            steps {
                sh 'docker start prometheus'
                echo 'Prometheus started.'
            }
        }
        stage('Start Grafana') {
            steps {
                sh 'docker start grafana'
                echo 'Grafana started.'
            }
        }
    }
    // Mailing functions
    post {
        success {
            script {
                success()
            }
        }
        failure {
            script {
                failure()
            }
        }
    }
}