<?php
require_once(dirname(__FILE__).'/widget.php');

class dfd_vcard_simple extends SB_WP_Widget {
	protected $widget_base_id = 'dfd_vcard_simple';
	protected $widget_name = 'Widget: vCard Simple';
	
	protected $options;
	
    public function __construct() {
		# Stup description
		$this->widget_params = array(
			'description' => __('Use this widget to add a simple vCard', 'dfd'),
		);
		
		$this->options = array(
			array(
				'title', 'text', '', 
				'label' => __('Title', 'dfd'), 
				'input'=>'text', 
				'filters'=>'widget_title', 
				'on_update'=>'esc_attr',
			),
			array(
				'address', 'text', '',
				'label' => __('Address', 'dfd'),
			),
			array(
				'phones', 'text', '',
				'label' => __('Phones', 'dfd'),
			),
			array(
				'display_email_as_link', 'text', '',
				'label' => __('Display Email as link', 'dfd'),
				'input' => 'checkbox',
			),
			array(
				'email', 'text', '',
				'label' => __('Email', 'dfd'),
			),
			array(
				'additional_info', 'text', '',
				'label' => __('Additional information', 'dfd'),
			),
			array(
				'display_two_columns', 'text', '',
				'label' => __('Show Additional information in separate column', 'dfd'),
				'input' => 'checkbox',
			),
			array(
				'show_titles', 'text', '',
				'label' => __('Show titles', 'dfd'),
				'input' => 'checkbox',
			),
		);
		
        parent::__construct();
    }
	
	/**
     * Display widget
     */
    function widget( $args, $instance ) {
        extract( $args );
		$this->setInstances($instance, 'filter');
		
        echo $before_widget;

		$title = $this->getInstance('title');
		
        if ( !empty( $title ) ) {
            echo $before_title . $title . $after_title;
		}
		
		$address = $this->getInstance('address');
		$phones = $this->getInstance('phones');
		$display_email_as_link = $this->getInstance('display_email_as_link');
		$email = $this->getInstance('email');
		$addition = $this->getInstance('additional_info');
		$show_columns = $this->getInstance('display_two_columns');
		$columns = !empty($show_columns) ? 'six' : 'twelve';
		$show_titles = $this->getInstance('show_titles');
		?>

		<div class="row">
			<div class="<?php echo esc_attr($columns); ?> columns">
				<?php if (!empty($phones)): ?>
					<div class="vcard-field">
						<i class="dfd-icon-call_incoming"></i>
						<?php if(!empty($show_titles)) : ?>
							<div class="vcard-field-name"><?php _e('Phone:', 'dfd'); ?></div>
						<?php endif; ?>
						<p><?php echo $phones; ?></p>
					</div>
				<?php endif; ?>
				<?php if (!empty($email)): ?>
					<div class="vcard-field">
						<i class="dfd-icon-send_mail"></i>
						<?php if(!empty($show_titles)) : ?>
							<div class="vcard-field-name"><?php _e('Email:', 'dfd'); ?></div>
						<?php endif; ?>
						<p>
						<?php if (!empty($display_email_as_link)): ?>
							<a href="mailto:<?php echo trim($email); ?>" title="" ><?php echo $email; ?></a>
						<?php else: ?>
							<span class="vcard-field-value"><?php echo $email; ?></span>
						</p>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php if (!empty($address)): ?>
					<div class="vcard-field">
						<i class="dfd-icon-map_marker"></i>
						<?php if(!empty($show_titles)) : ?>
							<div class="vcard-field-name"><?php _e('Address:', 'dfd'); ?></div>
						<?php endif; ?>
						<p><?php echo $address; ?></p>
					</div>
				<?php endif; ?>
				<?php echo (!empty($show_columns)) && (!empty($addition)) ? '</div><div class="'. esc_attr($columns) .' columns">' : ''; ?>
				<?php if (!empty($addition)): ?>
					<div class="vcard-field-add-info vcard-field">
						<i class="dfd-icon-info_doc2"></i>
						<?php if(!empty($show_titles)) : ?>
							<div class="vcard-field-name"><?php _e('Additional information:', 'dfd'); ?></div>
						<?php endif; ?>
						<p>
							<?php echo $addition; ?>
						</p>
					</div>
				<?php endif; ?>
			</div>
		</div>
		
		<?php
		
		echo $after_widget;
    }
	
}
