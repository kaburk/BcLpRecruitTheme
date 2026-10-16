<?php
declare(strict_types=1);
/**
 * BcLpRecruitTheme : baserCMS5 採用 LP テーマ
 */

namespace BcLpRecruitTheme\View\Helper;

use BcMail\Service\MailContentsServiceInterface;
use BaserCore\Utility\BcContainerTrait;
use Cake\View\Helper;

/**
 * BcLpRecruitTheme 用ヘルパー
 *
 * テーマの src/View/Helper に置くと、公開画面で自動的に読み込まれる（$this->Lp）
 */
class LpHelper extends Helper
{

    use BcContainerTrait;

    /**
     * 本文（BurgerEditor）から、ページ内ナビの項目を取り出す
     *
     * 「ID設定」をしたブロック（id="bge-xxx"）のうち、中に見出し（h1〜h3）があるものを、
     * 本文の並び順で返す。見出しの文字がナビの項目名になる。
     * 独自class「rc-blk--nonav」を付けたブロックは、ナビに載せない。
     *
     * @param string|null $contents 固定ページの本文
     * @return array<int, array{id: string, label: string}>
     */
    public function getNavItems(?string $contents): array
    {
        if (!$contents || !str_contains($contents, 'id="bge-')) {
            return [];
        }
        $dom = new \DOMDocument();
        $previous = libxml_use_internal_errors(true);
        $loaded = $dom->loadHTML('<?xml encoding="UTF-8"><div>' . $contents . '</div>', LIBXML_NOERROR | LIBXML_NOWARNING);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);
        if (!$loaded) {
            return [];
        }
        $xpath = new \DOMXPath($dom);
        $items = [];
        foreach ($xpath->query('//*[@data-bgb][starts-with(@id, "bge-")]') as $block) {
            /** @var \DOMElement $block */
            if (in_array('rc-blk--nonav', preg_split('/\s+/', $block->getAttribute('class')), true)) {
                continue;
            }
            $heading = $xpath->query('.//h1|.//h2|.//h3', $block)->item(0);
            if (!$heading) {
                continue;
            }
            $label = trim(preg_replace('/\s+/u', ' ', $heading->textContent));
            if ($label === '') {
                continue;
            }
            $items[] = ['id' => $block->getAttribute('id'), 'label' => $label];
        }
        return $items;
    }

    /**
     * サイト名（ロゴが未設定のときの文字、コピーライトに使う）
     *
     * テーマ設定のロゴの代替テキスト → サイトのタイトル の順で使う
     *
     * @param bool $preferLogoAlt ロゴの代替テキストを優先するか
     * @return string
     */
    public function getSiteLabel(bool $preferLogoAlt = true): string
    {
        if ($preferLogoAlt) {
            try {
                $configs = \Cake\ORM\TableRegistry::getTableLocator()->get('BcThemeConfig.ThemeConfigs')->getKeyValue();
                if (!empty($configs['logo_alt'])) {
                    return (string)$configs['logo_alt'];
                }
            } catch (\Throwable) {
            }
        }
        $site = $this->getView()->getRequest()->getAttribute('currentSite');
        return $site? (string)($site->title ?: $site->display_name) : '';
    }

    /**
     * 公開中の最初のメールフォームの URL を返す
     *
     * @return string フォームがなければ空文字
     */
    public function getFormUrl(): string
    {
        try {
            $site = $this->getView()->getRequest()->getAttribute('currentSite');
            $service = $this->getService(MailContentsServiceInterface::class);
            foreach ($service->getPublishedAll($site? (int)$site->id : null) as $mailContent) {
                if (!empty($mailContent->content->url)) {
                    return (string)$mailContent->content->url;
                }
            }
        } catch (\Throwable $e) {
            return '';
        }
        return '';
    }

}
