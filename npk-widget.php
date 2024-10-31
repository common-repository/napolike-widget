<?php
/*
 Plugin Name: Napolike Widget
 Version: 1.0
 Description: Questo widget permette di pubblicare sul vostro sito le ultime novità sulla vostra città. Viabilità, Sagre, eventi e tanto altro!
 Author: Matteo Morreale
 Author URI: https://madeit.srl
 */

// Matteo Morreale - CC Attribuzione non Commerciale
// Hai libertà di riutilizzare, modificare e condividere questo sorgente ma non a fini commerciali, ed è necessario citarne l'autore.

/**
 * Adds Napolike widget
 */
 
class Napolike_Widget extends WP_Widget {
    
    /**
     * Register widget with WordPress
     */
    function __construct() {
        parent::__construct(
            'napolike_widget', // Base ID
            esc_html__( 'Napolike', 'npk_text_domain' ), // Name
            array( 'description' => esc_html__( 'Questo widget ti permette di mostrare gli ultimi eventi, sagre e notizie di viabilità sulla nostra città.', 'npk_text_domain' ), ) // Args
            );
    }
    
    /**
     * Widget Fields
     */
    private $widget_fields = array(
        array(
            'label' => 'Quanti articoli mostrare per tipologia?',
            'id' => 'quantiarticolim_73719',
            'default' => '3',
            'type' => 'number',
        ),
        array(
            'label' => 'Mostra gli eventi a Napoli',
            'id' => 'mostraglieventi_43271',
            'type' => 'checkbox',
        ),
        array(
            'label' => 'Mostra le sagre',
            'id' => 'mostralesagrein_97729',
            'type' => 'checkbox',
        ),
        array(
            'label' => 'Mostra le news di viabilità',
            'id' => 'mostralenewsdiv_74247',
            'type' => 'checkbox',
        ),
    );
    
    /**
     * Front-end display of widget
     */
    public function widget( $args, $instance ) {
    
        wp_register_style( 'npk_widget', false );
        wp_enqueue_style( 'npk_widget' );
        
        wp_add_inline_style( 'npk_widget', '
        .notice {
            padding: 15px;
            background-color: #fafafa;
            border-left: 6px solid #7f7f84;
            margin-bottom: 10px;
            -webkit-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
            -moz-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
            box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
        }
        .notice-sm {
            padding: 10px;
            font-size: 80%;
        }
        .notice-lg {
            padding: 35px;
            font-size: large;
        }
        .notice-success {
            border-color: #80D651;
        }
        .notice-success>strong {
            color: #80D651;
        }
        .notice-info {
            border-color: #45ABCD;
        }
        .notice-info>strong {
            color: #45ABCD;
        }
        .notice-warning {
            border-color: #FEAF20;
        }
        .notice-warning>strong {
            color: #FEAF20;
        }
        .notice-danger {
            border-color: #d73814;
        }
        .notice-danger>strong {
            color: #d73814;
        }
        
        /* Loader */
        .spinner {
          -webkit-animation: rotator 1.4s linear infinite;
                  animation: rotator 1.4s linear infinite;
            max-width: 20px;            
            max-height: 20px;
            margin-left: 0px;
        }
        
        @-webkit-keyframes rotator {
          0% {
            -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
          }
          100% {
            -webkit-transform: rotate(270deg);
                    transform: rotate(270deg);
          }
        }
        
        @keyframes rotator {
          0% {
            -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
          }
          100% {
            -webkit-transform: rotate(270deg);
                    transform: rotate(270deg);
          }
        }
        .path {
          stroke-dasharray: 187;
          stroke-dashoffset: 0;
          -webkit-transform-origin: center;
              -ms-transform-origin: center;
                  transform-origin: center;
          -webkit-animation: dash 1.4s ease-in-out infinite, colors 5.6s ease-in-out infinite;
                  animation: dash 1.4s ease-in-out infinite, colors 5.6s ease-in-out infinite;
        }
        
        @-webkit-keyframes colors {
          0% {
            stroke: #4285F4;
          }
          25% {
            stroke: #DE3E35;
          }
          50% {
            stroke: #F7C223;
          }
          75% {
            stroke: #1B9A59;
          }
          100% {
            stroke: #4285F4;
          }
        }
        
        @keyframes colors {
          0% {
            stroke: #4285F4;
          }
          25% {
            stroke: #DE3E35;
          }
          50% {
            stroke: #F7C223;
          }
          75% {
            stroke: #1B9A59;
          }
          100% {
            stroke: #4285F4;
          }
        }
        @-webkit-keyframes dash {
          0% {
            stroke-dashoffset: 187;
          }
          50% {
            stroke-dashoffset: 46.75;
            -webkit-transform: rotate(135deg);
                    transform: rotate(135deg);
          }
          100% {
            stroke-dashoffset: 187;
            -webkit-transform: rotate(450deg);
                    transform: rotate(450deg);
          }
        }
        @keyframes dash {
          0% {
            stroke-dashoffset: 187;
          }
          50% {
            stroke-dashoffset: 46.75;
            -webkit-transform: rotate(135deg);
                    transform: rotate(135deg);
          }
          100% {
            stroke-dashoffset: 187;
            -webkit-transform: rotate(450deg);
                    transform: rotate(450deg);
          }
        }
        ' );

        echo $args['before_widget'];
        
        // Output widget title
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        ?>
        <style>


        </style>
        <div class="container">
        <?php 
        if($instance['mostraglieventi_43271']):
        ?>
            <div class="notice notice-success">
            	<strong><?php _e("Eventi","npk_lang"); ?></strong>
            </div>
            <div class="npk_widget_sub_events npk_eventi">
                <div class="notice notice-sm notice-spinner">
                    <div class="container">
                    	<svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                           <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
                        </svg>
                    </div>
                </div>
            </div>
        <?php
        endif;
        ?>
        <?php 
        if($instance['mostralesagrein_97729']):
        ?>
            <div class="notice notice-warning">
            	<strong><?php _e("Sagre","npk_lang"); ?></strong>
            </div>
            <div class="npk_widget_sub_events npk_sagre">
                <div class="notice notice-sm notice-spinner">
                    <div class="container">
                    	<svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                           <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
                        </svg>
                    </div>
                </div>
            </div>
        <?php
        endif;
        ?>
        <?php 
        if($instance['mostralenewsdiv_74247']):
        ?>
            <div class="notice notice-info">
            	<strong><?php _e("Viabilità","npk_lang"); ?></strong>
            </div>
            <div class="npk_widget_sub_events npk_viabilita">
                <div class="notice notice-sm notice-spinner">
                    <div class="container">
                    	<svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                           <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
                        </svg>
                    </div>
                </div>
            </div>
        <?php
        endif;
        ?>
        </div>
        
        <?php
        /*
        // Output generated fields
        echo '<p>'.$instance['quantiarticolim_73719'].'</p>';
        echo '<p>'.$instance['mostraglieventi_43271'].'</p>';
        echo '<p>'.$instance['mostralesagrein_97729'].'</p>';
        echo '<p>'.$instance['mostralenewsdiv_74247'].'</p>';
        */
        
        ?>
        <script>
        	var npk_quanti = 
        	<?php 
        	if ($instance['quantiarticolim_73719']) 
        	    echo $instance['quantiarticolim_73719']; 
        	else 
        	    echo 0; 
        	?>;

			var npk_eventi = 
        	<?php 
        	if ($instance['mostraglieventi_43271']) 
        	    echo $instance['mostraglieventi_43271']; 
        	else 
        	    echo 0; 
        	?>;

        	var npk_sagre = 
        	<?php 
        	if ($instance['mostralesagrein_97729']) 
        	    echo $instance['mostralesagrein_97729']; 
        	else 
        	    echo 0; 
        	?>;

			var npk_viabilita = 
        	<?php 
        	if ($instance['mostralenewsdiv_74247']) 
        	    echo $instance['mostralenewsdiv_74247']; 
        	else 
        	    echo 0; 
        	?>;

			var npk_site_url = "http://server1.madeit.srl:8080/https://www.napolike.it";
        </script>
        <?php
        
        echo $args['after_widget'];
    }
    
    /**
     * Back-end widget fields
     */
    public function field_generator( $instance ) {
        $output = '';
        foreach ( $this->widget_fields as $widget_field ) {
            $widget_value = ! empty( $instance[$widget_field['id']] ) ? $instance[$widget_field['id']] : esc_html__( $widget_field['default'], 'npk_text_domain' );
            switch ( $widget_field['type'] ) {
                case 'checkbox':
                    $output .= '<p>';
                    $output .= '<input class="checkbox" type="checkbox" '.checked( $widget_value, true, false ).' id="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'" name="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'" value="1">';
                    $output .= '<label for="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'">'.esc_attr( $widget_field['label'], 'npk_text_domain' ).'</label>';
                    $output .= '</p>';
                    break;
                default:
                    $output .= '<p>';
                    $output .= '<label for="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'">'.esc_attr( $widget_field['label'], 'npk_text_domain' ).':</label> ';
                    $output .= '<input class="widefat" id="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'" name="'.esc_attr( $this->get_field_name( $widget_field['id'] ) ).'" type="'.$widget_field['type'].'" value="'.esc_attr( $widget_value ).'">';
                    $output .= '</p>';
            }
        }
        echo $output;
    }
    
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'npk_text_domain' );
        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'npk_text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php
        $this->field_generator( $instance );
	}

	/**
	* Sanitize widget form values as they are saved
	*/
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		foreach ( $this->widget_fields as $widget_field ) {
			switch ( $widget_field['type'] ) {
				case 'checkbox':
					$instance[$widget_field['id']] = sanitize_key($_POST[$this->get_field_id( $widget_field['id'] )]);
					break;
				default:
					$instance[$widget_field['id']] = ( ! empty( $new_instance[$widget_field['id']] ) ) ? strip_tags( $new_instance[$widget_field['id']] ) : '';
			}
		}
		return $instance;
	}
} // class Napolike_Widget

// register Napolike widget
function register_napolike_widget() {
	register_widget( 'Napolike_Widget' );
}
add_action( 'widgets_init', 'register_napolike_widget' );

/* AJAX */
if ( is_active_widget( false, false, "napolike_widget" , true ) && !is_admin() ) {
    wp_enqueue_script( 'get_ajax_npk_widget', plugins_url( '/js/get_ajax_npk_widget.js', __FILE__ ), array('jquery'), '1.0', true ); // Questo è lo script ajax javascript
}