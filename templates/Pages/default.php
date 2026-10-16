<?php
/**
 * BcLpRecruitTheme : baserCMS 5 採用 LP テーマ
 *
 * 固定ページ（LP 本体）
 *
 * 本文はすべて BurgerEditor のブロックで組む。使える独自class は webroot/css/bge_style.css の冒頭を参照
 * BurgerEditor の autoWrapper が、このテンプレートの出力全体を div.bge-contents で包む。
 * bge_style.css は「.bge-contents > ブロック」を前提にしているので、本文を別の要素で包まないこと。
 *
 * @var \BaserCore\View\BcFrontAppView $this
 * @var \BaserCore\Model\Entity\Page $page
 */
?>
<?= $page->contents ?>
