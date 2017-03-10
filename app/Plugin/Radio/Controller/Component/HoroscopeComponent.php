<?php
App::uses('Component', 'Controller');

App::uses('HttpSocket', 'Network/Http');

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class HoroscopeComponent extends Component
{
    public function getTodayHoroscopes($isActive = 1)
    {
        if ($this->todayFileExists()) {
            return $this->getTodayFile();
        }

        $HttpSocket = new HttpSocket();

        $response   = $HttpSocket->get('http://developers.agenciaideias.com.br/horoscopo/json')->body;
        $response   = json_decode($response, true);

        $this->createTodayFile($response['signos']);
        $this->deleteOldFiles();

        return $this->getTodayFile();
    }

    private function todayFileExists()
    {
        $file = new File($this->getFolder() . $this->getTodayFileName());

        return $file->exists();
    }

    private function getTodayFile()
    {
        $file = new File($this->getFolder() . $this->getTodayFileName());

        return json_decode($file->read(), true);
    }

    private function createTodayFile($content = array())
    {
        $content = json_encode($content);

        $file = new File($this->getFolder() . $this->getTodayFileName(), true);
        $file->write($content);
        $file->close();
    }

    private function deleteOldFiles()
    {
        $dir   = new Folder($this->getFolder());
        $files = $dir->find('.*\.json');

        foreach ($files as $file) {

            if ($file == $this->getTodayFileName()) {
                continue;
            }

            $file = new File($dir->pwd() . DS . $file);
            $file->delete();
            $file->close();
        }
    }

    private function getFolder()
    {
        return APP . WEBROOT_DIR . DS . 'files' . DS . 'horoscope' . DS;
    }

    private function getTodayFileName()
    {
        return date('Y-m-d') . '.json';
    }
}
