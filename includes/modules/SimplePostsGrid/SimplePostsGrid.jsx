// External Dependencies
import React, {Component} from 'react';

// Internal Dependencies
import './style.css';

class CFSM_SimplePostsGrid extends Component {

    static slug = 'cfsm_posts_grid';

    constructor(props) {
        super(props);
        this.state = {needReload: true, queryData: {}, error: false};
    }

    componentDidMount() {
        this.doQuery();
    }

    componentDidUpdate(prevProps) {
        const props = this.props;
        const restart_after = ['post_type', 'posts_per_page', 'order', 'orderby'];
        restart_after.forEach(function (property) {
            if (props[property] !== prevProps[property]) {
                this.setState({needReload: true});
                this.doQuery();
            }
        }, this);
    }

    render() {
        if (this.state.needReload) {
            return (<div className="et-fb-loader-wrapper">
                <div className="et-fb-loader"/>
            </div>);
        } else if (this.state.error) {
            return (<div className='cfsm-main-container'>
                <b>{this.state.error}</b>
            </div>);
        } else {
            return (<div className='cfsm-main-container'>
                {this.renderItems()}
            </div>);
        }
    }

    renderItems() {
        if (this.state.queryData.length) {
            const Header = `${this.props.title_level}`;
            return this.state.queryData.map((item) => {
                return (<div className="cfsm-item" key={item.id}>
                    {this.props.show_image === 'on' && item.image !== '' &&
                        <div className="cfsm-item-image" dangerouslySetInnerHTML={{__html: item.image}}>
                        </div>}
                    {this.props.show_title === 'on' && <Header className="cfsm-item-title"
                                                               dangerouslySetInnerHTML={{__html: item.title}}></Header>}
                    {this.props.show_excerpt === 'on' && <div className="cfsm-item-excerpt"
                                                              dangerouslySetInnerHTML={{__html: item.excerpt}}></div>}
                    {this.props.show_read_more === 'on' && this.renderReadMore(item)}
                </div>)
            })
        } else {
            return (<p className="cfsm-no-results">No Results Found</p>);
        }
    }

    renderReadMore(item) {
        const props = this.props;
        const utils = window.ET_Builder.API.Utils;
        const buttonIcon = props.read_more_icon ? utils.processFontIcon(props.read_more_icon) : '5';
        const buttonClassName = {
            et_pb_button: true,
            et_pb_custom_button_icon: props.read_more_icon,
            'cfsm-read-more': true
        };
        return (
            <div className='et_pb_button_wrapper read-more-wrapper'>
                <a href={item.permalink}
                   rel={utils.linkRel(props.read_more_rel)}
                   data-icon={buttonIcon}
                   className={utils.classnames(buttonClassName)}>
                    Read More
                </a>
            </div>
        );
    }

    doQuery() {
        const data = new FormData();
        data.append('action', 'cfsm_get_posts_data_action');
        data.append('props', JSON.stringify(this.props));
        fetch(window.etCore.ajaxurl, {
            method: 'POST', body: data
        }).then((response) => response.json()).then((response) => {
            this.setState(() => ({needReload: false, queryData: response}));
        }).catch((error) => {
            this.setState(() => ({needReload: false, error: "Request failed: " + error}));
        });
    }

    static css(props) {
        const device = window.ET_Builder.API.State.View_Mode.current;
        let column = device === 'desktop' ? props.columns : props['columns_' + device];
        const columnsStyle = '1fr '.repeat(column);
        let gap = device === 'desktop' ? props.gaps : props['gaps_' + device];
        const additionalCss = [{}];
        additionalCss.push([{
            selector: '%%order_class%% .cfsm-main-container', declaration: `grid-template-columns: ${columnsStyle};`
        }]);
        additionalCss.push([{
            selector: '%%order_class%% .cfsm-main-container', declaration: `grid-gap: ${gap};`
        }]);
        return additionalCss;
    }
}

export default CFSM_SimplePostsGrid;
