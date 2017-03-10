<?php
App::uses('Component', 'Controller');

class RssComponent extends Component
{
    private $rssLinks = array(
        'g1'    => 'http://g1.globo.com/dynamo/rss2.xml',
        'zh'    => 'http://zh.clicrbs.com.br/rs/ultimas-noticias-rss/',
        'r7'    => 'http://noticias.r7.com/brasil/feed.xml',
        'folha' => 'http://feeds.folha.uol.com.br/emcimadahora/rss091.xml'
    );

    public function read($type = null)
    {
        if (is_null($type)) {
            return array();
        }

        return $this->getRss($type);
    }

    private function getRss($type = null)
    {
        $link = $this->rssLinks[$type];
        $xml  = Xml::toArray(Xml::build($link));

        return $this->getItems($xml);
    }

    private function getItems($xml = array(), $type = null)
    {
        if ($type == 'r7') {
            return $this->organizeItems($xml['feed']['entry']);
        }

        return $this->organizeItems($xml['rss']['channel']['item']);
    }

    private function organizeItems($items = array(), $type = null)
    {
        $organizedItems = array();

        foreach ($items as $key => $item) {
            $organizedItems[$key]['link']  = $this->getLink($item, $type);
            $organizedItems[$key]['title'] = $this->getTitle($item, $type);
        }

        return $organizedItems;
    }

    private function getLink($item = array(), $type = null)
    {
        if ($type == 'r7') {
            return $item['link']['@href'];
        }

        return $item['link'];
    }

    private function getTitle($item = array(), $type = null)
    {
        if ($type == 'r7') {
            return $item['title']['@'];
        }

        return $item['title'];
    }
}
