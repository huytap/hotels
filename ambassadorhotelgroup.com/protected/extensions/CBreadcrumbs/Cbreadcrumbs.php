<?php
/**
 * CBreadcrumbs class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CBreadcrumbs displays a list of links indicating the position of the current page in the whole website.
 *
 * For example, breadcrumbs like "Home > Sample Post > Edit" means the user is viewing an edit page
 * for the "Sample Post". He can click on "Sample Post" to view that page, or he can click on "Home"
 * to return to the homepage.
 *
 * To use CBreadcrumbs, one usually needs to configure its {@link links} property, which specifies
 * the links to be displayed. For example,
 *
 * <pre>
 * $this->widget('zii.widgets.CBreadcrumbs', array(
 *     'links'=>array(
 *         'Sample post'=>array('post/view', 'id'=>12),
 *         'Edit',
 *     ),
 * ));
 * </pre>
 *
 * Because breadcrumbs usually appears in nearly every page of a website, the widget is better to be placed
 * in a layout view. One can define a property "breadcrumbs" in the base controller class and assign it to the widget
 * in the layout, like the following:
 *
 * <pre>
 * $this->widget('zii.widgets.CBreadcrumbs', array(
 *     'links'=>$this->breadcrumbs,
 * ));
 * </pre>
 *
 * Then, in each view script, one only needs to assign the "breadcrumbs" property as needed.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package zii.widgets
 * @since 1.1
 */
class Cbreadcrumbs extends CWidget
{
	/**
	 * @var string the tag name for the breadcrumbs container tag. Defaults to 'div'.
	 */
	public $tagName='ul';
	/**
	 * @var array the HTML attributes for the breadcrumbs container tag.
	 */
	public $htmlOptions=array('class'=>'breadcrumb');
	/**
	 * @var boolean whether to HTML encode the link labels. Defaults to true.
	 */
	public $encodeLabel=true;
	public $homeLink;
	public $removeHome;
	public $links=array();
	public $activeLinkTemplate='<li><a href="{url}"> {label}</a></li>';
	public $inactiveLinkTemplate='<li class="active">{label}</li>';

	public $separator='';

	public function run()
	{
		if(empty($this->links))
			return;

		echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
		$links=array();

                 
                //custom home page
                
                if(in_array('removeHome', $this->links)){
                     $key = array_search('removeHome', $this->links);
                     unset($this->links[$key]);
                }else{
                       if($this->homeLink===null)  $links[]='<li><i class="fa fa-home"></i> '.CHtml::link('Home',Yii::app()->createAbsoluteUrl('/admin/default/admin')).'</li>';
                       elseif($this->homeLink!==false) $links[]=$this->homeLink;                 
                }    
 
		foreach($this->links as $label=>$url)
		{
			if(is_string($label) || is_array($url))
				$links[]=strtr($this->activeLinkTemplate,array(
					'{url}'=>CHtml::normalizeUrl($url),
					'{label}'=>$this->encodeLabel ? CHtml::encode($label) : $label,
				));
			else
				$links[]=str_replace('{label}',$this->encodeLabel ? CHtml::encode($url) : $url,$this->inactiveLinkTemplate);
		}
                
		echo implode($this->separator,$links);
		echo CHtml::closeTag($this->tagName);
	}
}