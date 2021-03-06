<?= $this->getXmlHead();?>
<yml_catalog date="<?=  date('Y-m-d H:i');?>">
<shop>
    <name><?= $model->shop_name; ?></name>
    <company><?= $model->shop_company; ?></company>
    <url><?= $model->shop_url; ?></url>
    <platform><?= $model->shop_platform; ?></platform>
    <version><?= $model->shop_version; ?></version>
    <agency><?= $model->shop_agency; ?></agency>
    <email><?= $model->shop_email; ?></email>
    <currencies>
        <?php foreach ($currencies as $currency): ?>
            <currency id="<?= $currency; ?>" <?= $currency === 'RUB' ? 'rate="1"' : '';?>/>
        <?php endforeach; ?>
    </currencies>
    <categories>
        <?php foreach($categories as $category):?>
            <category id="<?= $category->id?>" <?= $category->parent_id ? sprintf('parentId="%s"', $category->parent_id):'';?>><?= $category->name;?></category>
        <?php endforeach;?>
    </categories>
    <cpa><?= $model->shop_cpa; ?></cpa>
    <offers>
        <?php foreach($offers as $offer):?>
            <offer id="<?= $offer->id?>" type="vendor.model" available="<?= $offer->isInStock() ? 'true' : 'false';?>">
                <url><?= Yii::app()->createAbsoluteUrl('/store/product/view', ['name' => $offer->slug]);?></url>
                <price><?= $offer->getResultPrice();?></price>
                <oldprice><?= $offer->getBasePrice();?></oldprice>
                <currencyId><?= Yii::app()->getModule('store')->currency;?></currencyId>
                <categoryId><?= $offer->category_id;?></categoryId>
                <picture><?= StoreImage::product($offer); ?></picture>
                <name><?= htmlspecialchars(strip_tags($offer->name));?></name>
                <model><?= htmlspecialchars(strip_tags($offer->name));?></model>
                <vendor><?= htmlspecialchars(strip_tags($offer->producer->name));?></vendor>
                <description><?= htmlspecialchars(strip_tags($offer->description));?></description>
            </offer>
        <?php endforeach;?>
    </offers>
</shop>
</yml_catalog>