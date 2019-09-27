<?php
namespace News\Utils;

trait NewsUtils
{
    private function compareArrayAndObject(
        array $expectedArray,
        $news
    ) {
        $this->assertEquals($expectedArray['news_id'], $news->getId());
        $this->assertEquals($expectedArray['title'], $news->getTitle());
        $this->assertEquals($expectedArray['source'], $news->getSource());
        $image = array();

        if (is_string($expectedArray['image'])) {
            $image = json_decode($expectedArray['image'], true);
        }
        if (is_array($expectedArray['image'])) {
            $image = $expectedArray['image'];
        }

        $this->assertEquals($image, $news->getImage());
        $attachments = array();

        if (is_string($expectedArray['attachments'])) {
            $attachments = json_decode($expectedArray['attachments'], true);
        }
        if (is_array($expectedArray['attachments'])) {
            $attachments = $expectedArray['attachments'];
        }
        $this->assertEquals($attachments, $news->getAttachments());
        $this->assertEquals($expectedArray['publish_usergroup'], $news->getPublishUserGroup()->getId());
        $this->assertEquals($expectedArray['status'], $news->getStatus());
        $this->assertEquals($expectedArray['create_time'], $news->getCreateTime());
        $this->assertEquals($expectedArray['update_time'], $news->getUpdateTime());
        $this->assertEquals($expectedArray['status_time'], $news->getStatusTime());
    }
}
