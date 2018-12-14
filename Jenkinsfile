pipeline {
  agent any
  stages {
    stage('Build') {
      steps {
        slackSend(color: "#f0ad4e", message: ":rocket: STARTED: Job ${env.JOB_NAME} [${env.BUILD_NUMBER}] (${env.RUN_DISPLAY_URL})")
        sh 'docker-compose run --rm client composer install'
      }
    }
    stage('Test') {
      steps {
        sh 'docker-compose run --rm client bin/parallel-lint --exclude vendor .'
        sh 'docker-compose run --rm client bin/phpcs src/ tests/ --standard=PSR2,PSR12 --report=summary -p'
        sh 'docker-compose run --rm client bin/phpstan analyse -l max src/ tests/'
        sh 'docker-compose run --rm client bin/phpunit --log-junit ./reports/phpunit.xml  --coverage-xml reports/coverage'
      }
    }
    stage('Parse') {
      steps {
        script {
          def slurper = new XmlSlurper();
          slurper.setFeature("http://apache.org/xml/features/disallow-doctype-decl", false)
          slurper.setFeature("http://apache.org/xml/features/nonvalidating/load-external-dtd", false);
          def text = slurper.parseText(new File(pwd() + "/reports/coverage/index.xml").getText());
          def cov = text.phpunit.project.directory.totals.lines["percent"];
          println cov;
        }
      }
    }
  }
  post {
    success {
      slackSend(color: "#5cb85c", message: ":tada: SUCCESSFUL: Job ${env.JOB_NAME} [${env.BUILD_NUMBER}]")
    }
    failure {
      slackSend(color: "#d9534f", message: ":poop: FAILED: Job ${env.JOB_NAME} [${env.BUILD_NUMBER}]")
    }
    aborted {
      slackSend(color: "#292b2c", message: ":maga: ABORTED: Job ${env.JOB_NAME} [${env.BUILD_NUMBER}]")
    }
    always {
      junit 'reports/phpunit.xml'
      sh "docker-compose run --rm client rm -rf vendor/"
    }
  }
  environment {
    HOME    = '.'
    VERSION = "${env.JOB_BASE_NAME}-${env.BUILD_ID}"
  }
}
